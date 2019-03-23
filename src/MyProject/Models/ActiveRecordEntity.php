<?php

namespace MyProject\Models;

use MyProject\Services\Db;

abstract class ActiveRecordEntity
{
    /** @var int */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    /**
     * @param string $source
     * @return string
     */
    protected function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    /**
     * @param  string $source
     * @return  string
     */
    protected function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    /**
     * @return string
     */
    abstract protected static function getTableName(): string;

    /**
     * @return array[]
     */
    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM ' . static::getTableName() . ';', [], static::class);
    }

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $enteties = $db->query(
            'SELECT * FROM ' . static::getTableName() . ' WHERE id = :id;',
            [':id' => $id],
            static::class
        );
        return $enteties ? $enteties[0] : null;
    }

    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }
        return $mappedProperties;
    }

    public function save()
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    private function update(array $mappedProperties): void
    {
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $columns2params[] = $column . ' = :param' . $index;
            $params2values[':param' . $index] = $value;
            $index++;
        }

        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $this->id;
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    private function insert(array $mappedProperties): void
    {
        $mappedProperties = array_filter($mappedProperties);

        $columns = [];
        $params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $columns[] = $column;
            $params[] = ':' . $column;
            $params2values[':' . $column] = $value;
            $index++;

        }
        $sql = 'INSERT INTO ' . static::getTableName() . '(' . implode(', ', $columns) . ') VALUES (' . implode(', ', $params) . ');';
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
        $this->id = $db->getLastInsertId();
        $this->refresh();
    }

    public function refresh(): void
    {
        $objFromDb = static::getById($this->id);
        $reflector = new \ReflectionObject($objFromDb);
        $properties = $reflector->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $this->$propertyName = $property->getValue($objFromDb);
        }
    }

    public function delete(): void
    {
        $db = Db::getInstance();
        $db->query('DELETE FROM ' . static::getTableName() . ' WHERE id = :id',
            [':id' => $this->id], static::class);
        $this->id = null;
    }

    public static function findOneByColumn (string $columnName, string $value): ?self
    {
        $db = Db::getInstance();
        $result = $db->query('SELECT * FROM ' . static::getTableName() . ' WHERE ' . $columnName . ' = :value LIMIT 1;',
            [':value' => $value],
            static::class
        );

        return $result === [] ? null : $result[0];
    }
}