<?php
namespace App\Tables;

class History {
    const TABLE_NAME = 'history';
    const SHIFT_WITHDRAWN_SUCCESS = 'shift withdrawn success';
    const SHIFT_WITHDRAWN_ERROR = 'shift withdrawn error';

    const SHIFT_PROMOTE_SUCCESS = 'shift promote success';
    const SHIFT_PROMOTE_ERROR = 'shift promote error';

    const LOGIN_ERROR = 'login error';

	const SYSTEM_ERROR = 'system error';

    static function create_table(\PDO $connection): bool
    {
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `id_history` INTEGER PRIMARY KEY AUTOINCREMENT,
            `name` TEXT NOT NULL,
            `type` TEXT NOT NULL,
            `message` TEXT NOT NULL,
            `created` TEXT NOT NULL
            )';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select_all(\PDO $connection, array $type): array {
        $stmt = $connection->prepare(
            'SELECT name, type, message, created
            FROM ' . self::TABLE_NAME . '
            WHERE type = "' . join('" OR type = "', $type) . '"
            ORder BY created DESC'
        );

        if(!$stmt->execute())
        	return array();

        $result = $stmt->fetchAll();
        return ($result)? $result : array();
    }

    static function insert(\PDO $connection, string $name, string $type, string $message): bool {

        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . '
            (name, type, message, created)
		    VALUES (:name, :type, :message, datetime("now", "localtime"))'
        );

		return $stmt->execute(
            array(
                ':name' => $name,
                ':type' => $type,
                ':message' => $message
            )
        ) && $stmt->rowCount() == 1;
    }

    static function delete_old_entries(\PDO $connection): bool {
        $sql = 'DELETE FROM ' . self::TABLE_NAME . ' WHERE DATE(created) < date("now", "-2 months")';
        return ($connection->exec($sql) === false)? false : true;
    }
}