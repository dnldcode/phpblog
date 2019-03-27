<?php

namespace MyProject\Models\Articles;

use MyProject\Exceptions\InvalidArugmentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class Article extends ActiveRecordEntity
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $text;

    /** @var string */
    protected $authorId;

    /** @var bool */
    protected $isPublished;

    /** @var string */
    protected $createdAt;

    #
    # Getters
    #

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getShortText(): string
    {
        return substr($this->text, 0, 70);
    }

    /**
     * @return string
     */
    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getDate(): string
    {
        $date = new \DateTime($this->createdAt);
        return $date->format('Y-m-d');
    }

    /**
     * @return string
     */
    protected static function getTableName(): string
    {
        return 'articles';
    }

    /**
     * @return string
     */
    public function getParsedText(): string
    {
        return \Parsedown::instance()->text($this->getText());
    }

    #
    # Setters
    #

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @param string $authorId
     */
    public function setAuthorId(string $authorId): void
    {
        $this->authorId = $authorId;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }

    #
    # Methods
    #

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function publish(): void
    {
        $this->isPublished = true;
        $this->save();
    }

    public function hide(): void
    {
        $this->isPublished = '0';
        $this->save();
    }

    /**
     * @param array $fields
     * @param User $author
     * @return Article
     * @throws InvalidArugmentException
     */
    public static function createFromArray(array $fields, User $author): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArugmentException('Не передано название статьи');
        }

        if (empty($fields['text'])) {
            throw new InvalidArugmentException('Не передан текст статьи');
        }

        $article = new Article();

        $article->setAuthor($author);
        $article->setName($fields['name']);
        $article->setText($fields['text']);

        $article->save();

        return $article;
    }

    /**
     * @param array $fields
     * @return Article
     */
    public function updateFromArray(array $fields): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Не передано название статьи');
        }

        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }

        $this->setName($fields['name']);
        $this->setText($fields['text']);

        $this->save();

        return $this;
    }

    /**
     * @param int $id
     * @return array
     * @throws \MyProject\Exceptions\DbException
     */
    public static function getAllByUserId(int $id): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM ' . static::getTableName() . ' WHERE author_id = :author_id;', [':author_id' => $id], static::class);
    }

    /**
     * @return array
     * @throws \MyProject\Exceptions\DbException
     */
    public static function findAllPublished(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM ' . static::getTableName() . ' WHERE is_published = 1;', [], static::class);
    }

    /**
     * @return array
     * @throws \MyProject\Exceptions\DbException
     */
    public static function findAllNotPublished(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM ' . static::getTableName() . ' WHERE is_published = 0;', [], static::class);
    }
}