<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\Forbidden;
use MyProject\Exceptions\InvalidArugmentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class AdminPanelController extends AbstractController
{
    /**
     * @throws Forbidden
     * @throws UnauthorizedException
     * @throws \MyProject\Exceptions\DbException
     */
    public function view()
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new Forbidden('Недостаточно прав');
        }

        $articles = Article::findAllPublished();

        $this->view->renderHtml('admin/articles.php', ['title' => 'Админ панель', 'articles' => $articles]);
    }

    /**
     * @throws Forbidden
     * @throws UnauthorizedException
     * @throws \MyProject\Exceptions\DbException
     */
    public function comments()
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new Forbidden('Недостаточно прав');
        }

        $comments = Comment::findAll();
        $this->view->renderHtml('admin/comments.php', ['title' => 'Комментарии', 'comments' => $comments]);
    }

    /**
     * @param int $userId
     * @throws Forbidden
     * @throws NotFoundException
     * @throws UnauthorizedException
     * @throws \MyProject\Exceptions\DbException
     */
    public function articlesById(int $userId)
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new Forbidden('Недостаточно прав');
        }

        $user = User::getById($userId);

        if ($user === null) {
            throw new NotFoundException('Пользователь не найден');
        }

        $articles = Article::getAllByUserId($userId);
        $this->view->renderHtml('admin/userArticles.php', ['title' => 'Комментарии', 'articles' => $articles, 'profile' => $user]);
    }

    /**
     * @param int $userId
     * @throws Forbidden
     * @throws NotFoundException
     * @throws UnauthorizedException
     * @throws \MyProject\Exceptions\DbException
     */
    public function commentsById(int $userId)
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new Forbidden('Недостаточно прав');
        }

        $user = User::getById($userId);

        if ($user === null) {
            throw new NotFoundException('Пользователь не найден');
        }

        $comments = Comment::getAllByUserId($userId);

        $this->view->renderHtml('admin/userComments.php', ['title' => 'Комментарии', 'comments' => $comments, 'profile' => $user]);
    }

    /**
     * @throws Forbidden
     * @throws UnauthorizedException
     * @throws \MyProject\Exceptions\DbException
     */
    public function users()
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new Forbidden('Недостаточно прав');
        }

        $users = User::findAll();
        $this->view->renderHtml('admin/users.php', ['title' => 'Комментарии', 'users' => $users]);
    }

    /**
     * @param int $userId
     * @throws Forbidden
     * @throws NotFoundException
     * @throws UnauthorizedException
     * @throws \MyProject\Exceptions\DbException
     */
    public function userView(int $userId)
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new Forbidden('Недостаточно прав');
        }

        $user = User::getById($userId);

        if ($user === null) {
            throw new NotFoundException('Пользователь не найден');
        }

        if (!empty($_POST)) {
            try {
                $user->updateFromArray($_POST);
                $message = 'Успешно обновлено';
            } catch (InvalidArugmentException $e) {
                $this->view->renderHtml('admin/userView.php', ['title' => 'Комментарии', 'profile' => $user, 'error' => $e->getMessage()]);
                return;
            }
        }

        $this->view->renderHtml('admin/userView.php', ['title' => 'Комментарии', 'profile' => $user, 'message' => $message]);
    }

    /**
     * @throws Forbidden
     * @throws UnauthorizedException
     * @throws \MyProject\Exceptions\DbException
     */
    public function articlesToPublish()
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new Forbidden('Недостаточно прав');
        }

        $articles = Article::findAllNotPublished();
        $this->view->renderHtml('admin/articlesToPublish.php', ['title' => 'Комментарии', 'articles' => $articles]);
    }
}