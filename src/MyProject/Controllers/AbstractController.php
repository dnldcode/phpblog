<?php

namespace MyProject\Controllers;

use MyProject\Services\UsersAuthService;
use MyProject\View\View;
use MyProject\Models\Users\User;

abstract class AbstractController
{
    /** @var View */
    protected $view;

    /** @var User|null */
    protected $user;

    /**
     * AbstractController constructor.
     */
    public function __construct()
    {
        $this->user = UsersAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->view->setVar('user', $this->user);
    }

    /**
     * @return mixed
     */
    protected function getInputData()
    {
        return json_decode(
            file_get_contents('php://input'),
            true
        );
    }
}