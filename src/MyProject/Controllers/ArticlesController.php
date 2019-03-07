<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\View\View;
use MyProject\Services\Db;

class ArticlesController
{
    /** @var View */
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php', [
            'article' => $article
        ]);
    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $article->setName('Новое название статьи1');
        $article->setText('Новый текст статьи1');

        $article->save();
    }

    public function add()
    {
        $author = User::getById(1);

        $article = new Article();

        $article->setName('Новое название статьи');
        $article->setText('Новый текст статьи');
        $article->setAuthor($author);

        $article->save();
        $this->view->renderHtml('articles/ArticleAdded.php');
    }

    public function delete(int $articleId)
    {
        $article = Article::getById($articleId);
        if ($article === null) {
            $this->view->renderHtml('errors/NotFound.php', ['error' => 'Статья не может быть удалена, так как ее не существует!']);
        } else {
            $article->delete();
            $this->view->renderHtml('articles/ArticleDeleted.php');
        }
    }

}