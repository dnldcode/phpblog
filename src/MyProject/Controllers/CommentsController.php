<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\Forbidden;
use MyProject\Exceptions\InvalidArugmentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;

class CommentsController extends AbstractController
{
    /**
     * @param int $articleId
     * @throws InvalidArugmentException
     * @throws UnauthorizedException
     */
    public function addComment(int $articleId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $article = Article::getById($articleId);

        if ($article === null) {
            throw new InvalidArugmentException('Статья не найдена');
        }

        if (!empty($_POST)) {
            try {
                $comment = Comment::addComment($_POST['text'], $this->user, $articleId);
                header('Location: /articles/' . $articleId . '#comment' . $comment->getId());

            } catch (InvalidArugmentException $e) {
                $this->view->renderHtml('errors/commentError.php', ['error' => $e->getMessage()]);
            }
        } else
            header('Location: /articles/' . $articleId);
    }

    /**
     * @param int $commentId
     * @throws Forbidden
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function edit(int $commentId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $comment = Comment::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException('Комментарий не может быть изменен, так как он не существует!');
        }

        if (!$this->user->isAdmin() && $this->user->getId() !== $comment->getAuthorId()) {
            throw new Forbidden('Для изменения статьи нужно обладать правами администратора либо быть автором статьи');
        }
        if (!empty($_POST)) {
            try {
                $comment->updateComment($_POST['text']);
            } catch (InvalidArugmentException $e) {
                $this->view->renderHtml('errors/commentError.php', ['error' => $e->getMessage()]);
                exit();
            }
        }
        header('Location: /articles/' . $comment->getArticleId() . '#comment' . $comment->getId());
    }

    /**
     * @param int $commentId
     * @throws Forbidden
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function delete(int $commentId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $comment = Comment::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException('Комментарий не может быть удален, так как он не существует!');
        }

        if (!$this->user->isAdmin() && $this->user->getId() !== $comment->getAuthorId()) {
            throw new Forbidden('Для удаления статьи нужно обладать правами администратора либо быть автором статьи');
        }

        $articleId = $comment->getArticleId();
        $comment->delete();
        header('Location: /articles/' . $articleId);
    }
}