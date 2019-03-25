<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ActivationException;
use MyProject\Exceptions\InvalidArugmentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Users\UserActivationService;
use MyProject\Services\EmailSender;
use MyProject\Services\UsersAuthService;
use MyProject\Models\Users\User;

class UsersController extends AbstractController
{
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

    /**
     * @param int $userId
     * @param string $activationCode
     */
    public function activate(int $userId, string $activationCode): void
    {
        try {
            $user = User::getById($userId);

            if ($user === null) {
                throw new ActivationException('Невозможно найти пользователя');
            }

            if ($user->isActivated()) {
                throw new ActivationException('Данный аккаунт уже активирован');
            }
            $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
            if (!$isCodeValid) {
                throw new ActivationException('Код активации не действителен');
            }

            $user->activate();
            UserActivationService::deleteActivationCode($user);
            $this->view->renderHtml('users/activationSuccess.php');
        } catch (ActivationException $e) {
            $this->view->renderHtml('errors/activationError.php', ['error' => $e->getMessage()], 422);
        }
    }

    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArugmentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('users/login.php');
    }

    public function logout()
    {
        setcookie('token', '', -1, '/', '', false, true);
        header('Location: /');
    }

    /**
     * @param int $userId
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function show(int $userId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $profile = User::getById($userId);
        if ($profile === null) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('users/profile.php', ['profile' => $profile]);
    }

    /**
     * @throws UnauthorizedException
     */
    public function settings()
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_FILES)) {
            $file = $_FILES['attachment'];
            $newFilePath = __DIR__ . '/../../../www/uploads/photo' . $this->user->getId() . '.jpg';

            $imageSize = getimagesize($file['tmp_name']);

            $allowedExtensions = ['jpg', 'png', 'gif'];
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

            if (empty($file['name'])) {
                $error = 'Вы не выбрали фотографию!';
            } elseif (!in_array($extension, $allowedExtensions)) {
                $error = 'Загрузка файлов с таким расширением запрещена!';
            } elseif ($file['error'] == UPLOAD_ERR_INI_SIZE) {
                $error = 'Размер файла слишком большой';
            } elseif ($imageSize[0] > 1000 || $imageSize[1] > 1000) {
                $error = 'Недопустимое расширение изображения. Максимальное - 1000px x 1000px';
            } elseif ($file['error'] !== UPLOAD_ERR_OK || !move_uploaded_file($file['tmp_name'], $newFilePath)) {
                $error = 'Ошибка при загрузке файла';
            } else {
                $message = "Фотография успешно загружена";
                $this->user->updatePhoto('uploads/photo' . $this->user->getId() . '.jpg');
            }
        } elseif ($_POST['changePassword'] === '') {
            try {
                $this->user->changePassword($_POST);

                UsersAuthService::createToken($this->user);

                $message = 'Пароль успешно изменен';
            } catch (InvalidArugmentException $e) {
                $error = $e->getMessage();
            }
        }
        $this->view->renderHtml('users/settings.php', ['error' => $error, 'message' => $message]);
    }
}