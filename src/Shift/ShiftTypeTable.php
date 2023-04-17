<?php

namespace App\Shift;

class ShiftTypeTable
{
    public const TABLE_NAME = 'shift_types';

    public static function create_table(\PDO $connection): bool
    {
        $sql =
            'CREATE TABLE ' . self::TABLE_NAME . ' (
            `id_shift_type` INTEGER PRIMARY KEY AUTOINCREMENT,
            `name` TEXT NOT NULL,
            `user_per_shift_max` INTEGER DEFAULT 2,
            `info` TEXT,
            `updated` TEXT NOT NULL, 
            `created` TEXT NOT NULL
            )';

        return ($connection->exec($sql) === false) ? false : true;
    }

    public static function select(\PDO $connection, int $id_shift_type): array
    {
        $stmt = $connection->prepare(
            'SELECT name, info, user_per_shift_max, updated, created
          FROM ' . self::TABLE_NAME . '
          WHERE id_shift_type = :id_shift_type'
        );

        if (!$stmt->execute(
            array(':id_shift_type' => $id_shift_type)
        )) {
            return array();
        }

        $result = $stmt->fetch();
        return ($result) ? $result : array();
    }

    public static function select_name(\PDO $connection, int $id_shift_type): string
    {
        $stmt = $connection->prepare(
            'SELECT name
          FROM ' . self::TABLE_NAME . '
          WHERE id_shift_type = :id_shift_type'
        );

        if (!$stmt->execute(
            array(':id_shift_type' => $id_shift_type)
        )) {
            return '';
        }

        $result = $stmt->fetchColumn();
        return ($result) ? $result : '';
    }

    public static function select_first_id_shift_type(\PDO $connection): int
    {
        $stmt = $connection->prepare(
            'SELECT id_shift_type
          FROM ' . self::TABLE_NAME . ' LIMIT 1'
        );

        if (!$stmt->execute()) {
            return 0;
        }

        $result = $stmt->fetchColumn();
        return ($result) ? $result : 0;
    }

    public static function select_all(\PDO $connection): array
    {
        $stmt = $connection->prepare(
            'SELECT id_shift_type, name, info, user_per_shift_max FROM ' . self::TABLE_NAME
        );

        if (!$stmt->execute()) {
            return array();
        }

        $result = $stmt->fetchAll();
        return ($result) ? $result : array();
    }

    public static function insert(\PDO $connection, string $name, string $info, int $user_per_shift_max = 2): bool
    {
        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . '
            (name, info, user_per_shift_max, info, updated, created)
            VALUES (:name, :info, :user_per_shift_max, :info, datetime("now", "localtime"), datetime("now", "localtime"))'
        );

        return $stmt->execute(
            array(
                ':name' => $name,
                ':info' => $info,
                ':user_per_shift_max' => $user_per_shift_max
            )
        ) && $stmt->rowCount() == 1;
    }

    public static function update(\PDO $connection, int $id_shift_type, string $name, string $info, int $user_per_shift_max = 2): bool
    {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET name = :name, info = :info, user_per_shift_max = :user_per_shift_max, updated = datetime("now", "localtime")
            WHERE id_shift_type = :id_shift_type'
        );

        return $stmt->execute(
            array(
                ':name' => $name,
                ':info' => $info,
                ':user_per_shift_max' => $user_per_shift_max,
                ':id_shift_type' => $id_shift_type
            )
        ) && $stmt->rowCount() == 1;
    }

    public static function delete(\PDO $connection, int $id_shift_type): bool
    {
        $stmt = $connection->prepare(
            'DELETE FROM ' . self::TABLE_NAME . ' WHERE id_shift_type = :id_shift_type'
        );

        return $stmt->execute(
            array(':id_shift_type' => $id_shift_type)
        );
    }
}
