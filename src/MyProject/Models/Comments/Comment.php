<?php

namespace MyProject\Models\Comments;

use MyProject\Exceptions\InvalidArugmentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class Comment extends ActiveRecordEntity
{
    /** @var int */
    protected $authorId;

    /** @var string */
    protected $articleId;

    /** @var string */
    protected $text;

    /** @var string */
    protected $createdAt;

    /**
     * @return string
     */
    protected static function getTableName(): string
    {
        return 'comments';
    }

    /**
     * @param string $authorId
     */
    public function setAuthorId(string $authorId): void
    {
        $this->authorId = $authorId;
    }

    /**
     * @param string $articleId
     */
    public function setArticleId(string $articleId): void
    {
        $this->articleId = $articleId;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
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
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getArticleId(): string
    {
        return $this->articleId;
    }

    /**
     * @return Comment[]
     */
    public static function findAllByArticleId(int $articleId): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM ' . static::getTableName() . ' WHERE article_id = :article_id',
            [':article_id' => $articleId],
            static::class
        );
    }

    public static function addComment(string $text, User $author, int $articleId): ?self
    {
        if (empty($text)) {
            throw new InvalidArugmentException('Комментарий пустой');
        }

        $comment = new Comment();

        $comment->setText($_POST['text']);
        $comment->setArticleId($articleId);
        $comment->setAuthorId($author->getId());

        $comment->save();

        return $comment;
    }

    public function updateComment(string $text): ?self
    {
        if (empty($text)){
            throw new InvalidArugmentException('Текст комментария пустой');
        }

        $this->text = $text;
        $this->save();

        return $this;
    }

    public static function deleteCommentsInArticle(int $articleId)
    {
        $db = Db::getInstance();
        $db->query('DELETE FROM ' . static::getTableName() . ' WHERE article_id = :article_id',
            [':article_id' => $articleId], static::class);
    }
}