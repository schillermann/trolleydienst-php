<?php
namespace Tables;

class LoginFails {

	const TABLE_NAME = 'login_fails';

	static function create_table(\PDO $connection): bool {
		$sql =
			'CREATE TABLE `' . self::TABLE_NAME . '` (
			`ip` TEXT PRIMARY KEY,
			`fail` INTEGER DEFAULT 1,
			`ban` TEXT,
			`updated` TEXT NOT NULL
		)';

		return ($connection->exec($sql) === false)? false : true;
	}

	static function select_ban_and_updated(\PDO $connection, string $ip): array {
		$stmt = $connection->prepare(
			'SELECT ban, updated
            FROM ' . self::TABLE_NAME . '
            WHERE ip = :ip'
		);

		if(!$stmt->execute(
			array(':ip' => $ip)
		))
			return array();

		$result = $stmt->fetch();

		if(!$result)
			return array();

		return array(
			'ban' => new \DateTime($result['ban']),
			'updated' => new \DateTime($result['updated'])
		);
	}

	static function select_fail(\PDO $connection, string $ip): int {
		$stmt = $connection->prepare(
			'SELECT fail
            FROM ' . self::TABLE_NAME . '
            WHERE ip = :ip'
		);

		$stmt->execute(
			array(':ip' => $ip)
		);
		$fail = $stmt->fetchColumn();
		return ($fail)? $fail : 0;
	}

	static function select_ban(\PDO $connection, string $ip): string {
		$stmt = $connection->prepare(
			'SELECT ban
            FROM ' . self::TABLE_NAME . '
            WHERE ip = :ip'
		);

		$stmt->execute(
			array(':ip' => $ip)
		);
		$ban = $stmt->fetchColumn();
		return ($ban)? $ban : '';
	}

	static function is_ban(\PDO $connection, string $ip): bool {
		$stmt = $connection->prepare(
			'SELECT COUNT(*)
            FROM ' . self::TABLE_NAME . '
            WHERE ip = :ip
            AND ban IS NOT NULL'
		);

		$stmt->execute(
			array(':ip' => $ip)
		);

		return (int)$stmt->fetchColumn() > 0;
	}

	static function update_fail(\PDO $connection, string $ip) {
		$stmt = $connection->prepare(
			'UPDATE ' . self::TABLE_NAME . '
            SET fail = fail + 1, updated = datetime("now", "localtime")
            WHERE ip = :ip'
		);

		return $stmt->execute(
				array(
					':ip' => $ip
				)
			) && $stmt->rowCount() == 1;
	}

	static function update_ban(\PDO $connection, string $ip) {
		$stmt = $connection->prepare(
			'UPDATE ' . self::TABLE_NAME . '
            SET fail = fail + 1, ban = datetime("now", "localtime"), updated = datetime("now", "localtime")
            WHERE ip = :ip'
		);

		return $stmt->execute(
				array(
					':ip' => $ip
				)
		) && $stmt->rowCount() == 1;
	}

	static function insert(\PDO $connection, string $ip) {
		$stmt = $connection->prepare(
			'INSERT INTO ' . self::TABLE_NAME . '
            (ip, updated) VALUES (:ip, datetime("now", "localtime"))'
		);

		return $stmt->execute(
			array(
				':ip' => $ip
			)
		) && $stmt->rowCount() == 1;
	}

	static function delete(\PDO $connection, string $ip): bool {
		$stmt = $connection->prepare(
			'DELETE FROM ' . self::TABLE_NAME . ' WHERE ip = :ip'
		);

		return $stmt->execute(
			array(':ip' => $ip)
		);
	}
}