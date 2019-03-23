<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;

class MainController extends AbstractController
{
    public function main()
    {
        $articles = Article::findAllPublished();
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }
}