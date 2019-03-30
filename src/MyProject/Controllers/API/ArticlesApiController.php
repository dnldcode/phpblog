<?php

namespace MyProject\Controllers\Api;

use MyProject\Controllers\AbstractController;
use MyProject\Exceptions\InvalidArugmentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;

class ArticlesApiController extends AbstractController
{
    /**
     * @param int $articleId
     * @throws NotFoundException
     * @throws \MyProject\Exceptions\DbException
     */
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $this->view->displayJson(['articles' => $article->jsonSerialize()]);
    }

    /**
     * @throws InvalidArugmentException
     * @throws \MyProject\Exceptions\DbException
     */
    public function add()
    {
        $input = $this->getInputData();

        $articleFromRequest = $input['articles'][0];

        $authorId = $articleFromRequest['author_id'];
        $author = User::getById($authorId);

        if ($author === null) {
            throw new InvalidArugmentException('Не передан автор');
        }

        $article = Article::createFromArray($articleFromRequest, $author);
        $article->save;

        header('Location: /api/articles/' . $article->getId(), true, 302);
    }
}