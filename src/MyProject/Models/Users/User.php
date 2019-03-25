<?php

namespace MyProject\Models\Users;

use MyProject\Exceptions\InvalidArugmentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Services\UsersAuthService;

class User extends ActiveRecordEntity
{
    /** @var string */
    protected $nickname;

    /** @var string */
    protected $email;

    /** @var bool */
    protected $isConfirmed;

    /** @var string */
    protected $role;

    /** @var string */
    protected $photo;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $authToken;

    /** @var string */
    protected $createdAt;

    /*  Getters and Setters */

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    protected static function getTableName(): string
    {
        return 'users';
    }

    /**
     * @return string
     */
    public function getPhoto(): string
    {
        if (!file_exists(__DIR__ . '/../../../../www/' . $this->photo)) {
            $this->photo = '';
            $this->save();

            return 'uploads/default.png';
        }

        if (empty($this->photo))
            return 'uploads/default.png';
        else
            return $this->photo;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @return string
     */
    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function getRegistrationDate(): string
    {
        $date = new \DateTime($this->createdAt);
        return $date->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $isConfirmed
     */
    public function setIsConfirmed(string $isConfirmed): void
    {
        $this->isConfirmed = $isConfirmed;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /* /Getters and Setters */

    /**
     * @param array $userData
     * @return User
     * @throws InvalidArugmentException
     */
    public static function signUp(array $userData): User
    {
        if (empty($userData['nickname']))
            throw new InvalidArugmentException('Не передан nickname');

        if (!preg_match('/[a-zA-Z0-9]+/', $userData['nickname']))
            throw new InvalidArugmentException('Nickname может состоять только из символов латинского алфавита и цифр');

        if (empty($userData['email']))
            throw new InvalidArugmentException('Не передан email');

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL))
            throw new InvalidArugmentException('Email некорректен');

        if (empty($userData['password']))
            throw new InvalidArugmentException('Не передан password');

        if (mb_strlen($userData['password']) < 8)
            throw new InvalidArugmentException('Пароль должен быть не менее 8 символов');

        if (static::findOneByColumn('nickname', $userData['nickname']) !== null)
            throw new InvalidArugmentException('Пользователь с таким nickname уже существует');

        if (static::findOneByColumn('email', $userData['email']) !== null)
            throw new InvalidArugmentException('Пользователь с таким email уже существует');

        $user = new User();
        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->isConfirmed = false;
        $user->role = 'user';
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();

        return $user;
    }

    public function activate(): void
    {
        $this->isConfirmed = true;
        $this->save();
    }

    public function isActivated()
    {
        return $this->isConfirmed;
    }

    /**
     * @param array $loginData
     * @return User
     * @throws InvalidArugmentException
     */
    public static function login(array $loginData): User
    {
        if (empty($loginData['email'])) {
            throw new InvalidArugmentException('Не передан email');
        }

        if (empty($loginData['password'])) {
            throw new InvalidArugmentException('Не передан пароль');
        }

        $user = User::findOneByColumn('email', $loginData['email']);
        if ($user === null) {
            throw new InvalidArugmentException('Нет пользователя с таким email');
        }

        if (!password_verify($loginData['password'], $user->getPasswordHash())) {
            throw new InvalidArugmentException('Неправильный пароль');
        }

        if (!$user->isActivated()) {
            throw new InvalidArugmentException('Пользователь не подтвержден');
        }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }

    public function refreshAuthToken(): void
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

    public function isAdmin(): bool
    {
        return $this->role === admin;
    }

    /**
     * @param string $path
     */
    public function updatePhoto(string $path): void
    {
        $this->photo = $path;
        $this->save();
    }

    /**
     * @param array $fields
     * @return User
     * @throws InvalidArugmentException
     */
    public function updateFromArray(array $fields): User
    {
        if (empty($fields['email'])) {
            throw new InvalidArugmentException('Не передан email');
        }

        if ($fields['activated'] !== '0' && empty($fields['activated'])) {
            throw new InvalidArugmentException('Не передано поле activated');
        }

        if (empty($fields['role'])) {
            throw new InvalidArugmentException('Не передана роль');
        }
        $this->setEmail($fields['email']);
        $this->setIsConfirmed($fields['activated']);
        $this->setRole($fields['role']);

        $this->save();

        return $this;
    }

    /**
     * @param array $password
     * @throws InvalidArugmentException
     */
    public function changePassword(array $password): void
    {
        if (empty($password['password'])) {
            throw new InvalidArugmentException('Старый пароль не передан');
        }

        if (empty($password['newPassword'])) {
            throw new InvalidArugmentException('Новый пароль не передан');
        }

        if (empty($password['newPasswordConfirmed'])) {
            throw new InvalidArugmentException('Вы не повторили новый пароль');
        }

        if (!password_verify($password['password'], $this->getPasswordHash())) {
            throw new InvalidArugmentException('Неверный старый пароль');
        }

        if (strlen($password['newPassword']) < 6) {
            throw new InvalidArugmentException('Новый пароль должен быть не менее 6 символов в длину');
        }

        if ($password['newPassword'] !== $password['newPasswordConfirmed']) {
            throw new InvalidArugmentException('Новые пароли не совпадают');
        }

        if ($password['password'] === $password['newPassword']) {
            throw new InvalidArugmentException('Новый и старый пароли должны отличаться');
        }

        $this->passwordHash = password_hash($password['newPassword'], PASSWORD_DEFAULT);

        $this->refreshAuthToken();
        $this->save();
    }
}