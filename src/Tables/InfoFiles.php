<?php
namespace App\Tables;

class InfoFiles {

    const TABLE_NAME = 'info_files';

    static function create_table(\PDO $connection): bool
    {
        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
				`id_info` INTEGER PRIMARY KEY,
				`file_resource`	BLOB NOT NULL
            )';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function select(\PDO $connection, int $id_info) {
        $stmt = $connection->prepare(
            'SELECT file_resource
            FROM ' . self::TABLE_NAME . '
            WHERE id_info = :id_info'
        );
		if(!$stmt->execute([':id_info' => $id_info]))
			return null;

		$stmt->bindColumn(1, $file_resource, \PDO::PARAM_LOB);

		return $stmt->fetch(\PDO::FETCH_BOUND)? $file_resource : null;
    }

    static function insert(\PDO $connection, int $id_info, $file_resource): bool {

		$stmt = $connection->prepare(
			'INSERT INTO ' . self::TABLE_NAME . '
			 (id_info, file_resource)
			 VALUES (:id_info, :file_resource)'
		);
		$stmt->bindParam(':id_info', $id_info);
		$stmt->bindParam(':file_resource', $file_resource, \PDO::PARAM_LOB);

		return $stmt->execute() && $stmt->rowCount() == 1;
    }
}