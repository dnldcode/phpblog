<?php

namespace MyProject\Models\Users;

use MyProject\Services\Db;

class UserActivationService
{
    /** @var string  */
    private const TABLE_NAME = 'users_activation_codes';

    /**
     * @param User $user
     * @return string
     * @throws \Exception
     */
    public static function createActivationCode(User $user): string
    {
        $code = bin2hex(random_bytes(16));

        $db = Db::getInstance();
        $db->query(
            'INSERT INTO ' . self::TABLE_NAME . ' (user_id, code) VALUES (:user_id, :code)',
            [
                'user_id' => $user->getId(),
                'code' => $code
            ]
        );

        return $code;
    }

    /**
     * @param User $user
     * @param string $code
     * @return bool
     * @throws \MyProject\Exceptions\DbException
     */
    public static function checkActivationCode(User $user, string $code): bool
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE user_id = :user_id AND code = :code',
            [
                'user_id' => $user->getId(),
                'code' => $code
            ]
        );
        return !empty($result);
    }

    /**
     * @param User $user
     * @throws \MyProject\Exceptions\DbException
     */
    public static function deleteActivationCode(User $user)
    {
        $db = Db::getInstance();
        $db->query('DELETE FROM ' . self::TABLE_NAME . ' WHERE user_id = :user_id',
            [':user_id' => $user->getId()]
        );
    }
}