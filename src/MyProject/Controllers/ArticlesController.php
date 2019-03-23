<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\Forbidden;
use MyProject\Exceptions\InvalidArugmentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;

class ArticlesController extends AbstractController
{
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!$article->isPublished() && !$this->user->isAdmin() && $article->getAuthorId() !== $this->user->getId()) {
            throw new Forbidden('Для просмотра статьи нужно обладать правами администратора');
        }

        $this->view->renderHtml('articles/view.php', [
            'article' => $article,
            'comments' => Comment::findAllByArticleId($articleId)
        ]);
    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new Forbidden('Для изменения статьи нужно обладать правами администратора');
        }

        if (!empty($_POST)) {
            try {
                $article->updateFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/edit.php', ['error' => $e->getMessage(), 'article' => $article]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }

    public function add()
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }


        if (!empty($_POST)) {
            try {
                $article = Article::createFromArray($_POST, $this->user);
            } catch (InvalidArugmentException $e) {
                $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('articles/add.php');
    }

    public function delete(int $articleId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/NotFound.php', ['error' => 'Статья не может быть удалена, так как ее не существует!']);
        }

        if (!$this->user->isAdmin() && $article->getAuthorId() !== $this->user->getId()) {
            throw new Forbidden('Для удаления статьи нужно обладать правами администратора');
        }

        Comment::deleteCommentsInArticle($article->getId());
        $article->delete();
        $this->view->renderHtml('articles/ArticleDeleted.php');
    }

    public function articlesByUser()
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $articles = Article::getAllByUserId($this->user->getId());
        $this->view->renderHtml('users/articles.php', ['articles' => $articles]);
    }

    public function publish(int $articleId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new Forbidden('Для опубликования статьи нужно обладать правами администратора');
        }

        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/NotFound.php', ['error' => 'Статья не может быть удалена, так как ее не существует!']);
        } else {
            $article->publish();
            header('Location: /articles/' . $article->getId());
        }
    }

    public function hide(int $articleId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new Forbidden('Для опубликования статьи нужно обладать правами администратора');
        }

        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/NotFound.php', ['error' => 'Статья не может быть удалена, так как ее не существует!']);
        } else {
            $article->hide();
            header('Location: /articles/' . $article->getId());
        }
    }
}