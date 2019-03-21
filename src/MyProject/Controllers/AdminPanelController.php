<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\Forbidden;
use MyProject\Exceptions\UnauthorizedException;

class AdminPanelController extends AbstractController
{
    public function view()
    {
        if (empty($this->user)) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new Forbidden();
        }

        $this->view->renderHtml('admin/articles.php', ['title' => 'Админ панель']);
    }
}