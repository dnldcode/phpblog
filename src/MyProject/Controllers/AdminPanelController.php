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
    public function view()
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new Forbidden('Недостаточно прав');
        }

        $articles = Article::findAll();

        $this->view->renderHtml('admin/articles.php', ['title' => 'Админ панель', 'articles' => $articles]);
    }

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

    public function articlesById(int $id)
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new Forbidden('Недостаточно прав');
        }

        $user = User::getById($id);

        if ($user === null) {
            throw new NotFoundException('Пользователь не найден');
        }

        $articles = Article::getAllByUserId($id);
        $this->view->renderHtml('admin/userArticles.php', ['title' => 'Комментарии', 'articles' => $articles, 'profile' => $user]);
    }

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

    public function userView(int $id)
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new Forbidden('Недостаточно прав');
        }

        $user = User::getById($id);

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
}