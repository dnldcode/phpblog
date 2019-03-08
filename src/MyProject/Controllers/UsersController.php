<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ActivationException;
use MyProject\Exceptions\InvalidArugmentException;
use MyProject\Models\Users\UserActivationService;
use MyProject\Services\EmailSender;
use MyProject\View\View;
use MyProject\Models\Users\User;

class UsersController
{
    /** @var View */
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArugmentException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }
            if ($user instanceof User) {
                $code = UserActivationService::createActivationCode($user);

                EmailSender::send($user, 'Активация', 'userActivation.php', [
                    'userId' => $user->getId(),
                    'code' => $code
                ]);

                $this->view->renderHtml('users/signUpSuccessful.php');
                return;
            }
        }

        $this->view->renderHtml('users/signUp.php');
    }

    public function activate(int $userId, string $activationCode): void
    {
        try {
            $user = User::getById($userId);

            if ($user === null) {
                throw new ActivationException('User was not found');
            }

            if ($user->isActivated()) {
                throw new ActivationException('User is already activated');
            }
            $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
            if (!$isCodeValid) {
                throw new ActivationException('Code is not valid');
            }

            $user->activate();
            UserActivationService::deleteActivationCode($user);
            $this->view->renderHtml('users/activationSuccess.php');
        } catch (ActivationException $e) {
            $this->view->renderHtml('errors/activationError.php', ['error' => $e->getMessage()], 422);
        }
    }
}