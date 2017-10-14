<?php
namespace Tables;

class Infos {

    const TABLE_NAME = 'infos';

    static function create_table(\PDO $connection): bool
    {
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
				`id_info` INTEGER PRIMARY KEY AUTOINCREMENT,
				`label` TEXT NOT NULL UNIQUE,
				`mime_type`	TEXT NOT NULL,
				`created` TEXT NOT NULL
            )';

        return ($connection->exec($sql) === false)? false : true;
    }

	static function select_label(\PDO $connection, int $id_info): string {
		$stmt = $connection->prepare(
			'SELECT label
            FROM ' . self::TABLE_NAME . '
            WHERE id_info = :id_info'
		);

		$stmt->execute(
			array(':id_info' => $id_info)
		);
		$label = $stmt->fetchColumn();
		return ($label)? $label : '';
	}

    static function select_all(\PDO $connection): array {
        $stmt = $connection->query(
            'SELECT id_info, label, mime_type
            FROM ' . self::TABLE_NAME . '
            ORDER BY label'
        );

        $result = $stmt->fetchAll();
        return ($result === false)? array() : $result;
    }

    static function select_mime_type(\PDO $connection, int $id_info): string {
        $stmt = $connection->prepare(
            'SELECT mime_type
            FROM ' . self::TABLE_NAME . '
            WHERE id_info = :id_info'
        );

        if(!$stmt->execute(
            array(':id_info' => $id_info)
        ))
        	return '';
        $mime_type = $stmt->fetchColumn();
        return ($mime_type)? $mime_type : '';
    }

    static function insert(\PDO $connection, string $label, string $mime_type): int {

		$stmt = $connection->prepare(
			'INSERT INTO ' . self::TABLE_NAME . '
			 (label, mime_type, created)
			 VALUES (:label, :mime_type, datetime("now", "localtime"))'
		);
		if($stmt->execute(
			array(
				':label' => $label,
				':mime_type' => $mime_type
			)
		))
			return $connection->lastInsertId();
		else
			return 0;
    }

    static function delete(\PDO $connection, int $id_info): bool {
        $stmt = $connection->prepare(
            'DELETE FROM ' . self::TABLE_NAME . ' WHERE id_info = :id_info'
        );

        return $stmt->execute(
            array(':id_info' => $id_info)
        );
    }

    static function update(\PDO $connection, int $id_info, string $label): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . ' SET label = :label WHERE id_info = :id_info'
        );

        return $stmt->execute(
            array(
                ':label' => $label,
                ':id_info' => $id_info
            )
        );
    }
}