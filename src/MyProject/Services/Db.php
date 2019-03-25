<?php

namespace MyProject\Services;

use MyProject\Exceptions\DbException;

class Db
{
    /** @var Db */
    private static $instance;

    /** @var \PDO */
    private $pdo;

    /**
     * Db constructor.
     * @throws DbException
     */
    private function __construct()
    {
        $dbOptions = (require __DIR__ . '/../../settings.php')['db'];
        try {
            $this->pdo = new \PDO(
                'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
                $dbOptions['user'], $dbOptions['password']
            );
            $this->pdo->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new DbException('Ошибка при подключении к базе данных: ' . $e->getMessage());
        }
    }

    /**
     * @param string $sql
     * @param array $params
     * @param string $className
     * @return array|null
     */
    public function query(string $sql, $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if ($result === null) {
            return null;
        }
        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    /**
     * @return Db
     * @throws DbException
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return int
     */
    public function getLastInsertId(): int
    {
        return (int)$this->pdo->lastInsertId();
    }
}