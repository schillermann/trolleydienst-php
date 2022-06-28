<?php
namespace App\Tables;

class Settings {

    const TABLE_NAME = 'settings';

    static function create_table(\PDO $connection): bool
    {  
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `name` TEXT PRIMARY KEY,
            `value` TEXT,
            `updated` TEXT NOT NULL,
            `created` TEXT NOT NULL
        )';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select(\PDO $connection, string $name): string {
        $stmt = $connection->prepare(
            'SELECT value
            FROM ' . self::TABLE_NAME . '
            WHERE name = :name'
        );

        $stmt->execute(
            array(':name' => $name)
        );
        $value = $stmt->fetchColumn();
        return ($value)? $value : '';
    }

    static function insert(\PDO $connection, string $name, string $value): int {

        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . '
             (name, value, updated, created)
             VALUES (:name, :value, datetime("now", "localtime"), datetime("now", "localtime"))'
        );
        if($stmt->execute(
            array(
                ':name' => $name,
                ':value' => $value
            )
        ))
            return $connection->lastInsertId();
        else
            return 0;
    }

    static function update(\PDO $connection, string $name, string $value): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET value = :value, updated = datetime("now", "localtime")
            WHERE name = :name'
        );

        return $stmt->execute(
            array(
                ':name' => $name,
                ':value' => $value
            )
        );
    }
}