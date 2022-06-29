<?php
namespace App\Tables;

class Reports
{

	const TABLE_NAME = 'reports';

	static function create_table(\PDO $connection): bool
	{
		$sql =
			'CREATE TABLE `' . self::TABLE_NAME . '` (
				`id_report`	INTEGER PRIMARY KEY AUTOINCREMENT,
				`id_shift_type`	INTEGER NOT NULL,
				`name` TEXT NOT NULL,
				`route` TEXT NOT NULL,
				`book` INTEGER DEFAULT 0,
				`brochure` INTEGER DEFAULT 0,
				`bible`	INTEGER DEFAULT 0,
				`magazine` INTEGER DEFAULT 0,
				`tract`	INTEGER DEFAULT 0,
				`address` INTEGER DEFAULT 0,
				`talk` INTEGER DEFAULT 0,
				`note_user` TEXT,
				`shift_datetime_from` TEXT NOT NULL,
				`created` TEXT NOT NULL
            )';

		return ($connection->exec($sql) === false) ? false : true;
	}

	static function select_all(\PDO $connection, \DateTime $from, \DateTime $to, int $id_shift_type, string $name = ''): array {

		$where_name = (empty($name))? ' ' : ' AND name = "' . $name . '" ';

		$stmt = $connection->prepare(
			'SELECT id_report, name, route, shift_datetime_from, book,
            brochure, bible, magazine, tract, address, talk, note_user, created
            FROM ' . self::TABLE_NAME . '
            WHERE id_shift_type = :id_shift_type' . $where_name .
            'AND DATE(shift_datetime_from) >= DATE(:from)
            AND DATE(shift_datetime_from) <= DATE(:to)
            ORDER BY shift_datetime_from DESC'
		);

		if(!$stmt->execute(
			array(
				':from' => $from->format('Y-m-d H:i:s'),
				':to' => $to->format('Y-m-d H:i:s'),
				':id_shift_type' => $id_shift_type
			)
		))
			return array();

		$result = $stmt->fetchAll();
		return ($result)? $result : array();
	}

	static function insert(\PDO $connection, \App\Models\Report $report): bool {
		$stmt = $connection->prepare(
			'INSERT INTO ' . self::TABLE_NAME . '
			(
			    id_shift_type, name, route, book, brochure, bible, magazine,
			    tract, address, talk, note_user, shift_datetime_from, created
			)
            VALUES (
                :id_shift_type, :name, :route, :book, :brochure, :bible, :magazine,
                :tract, :address, :talk, :note_user, :shift_datetime_from, datetime("now", "localtime")
            )'
		);

		return $stmt->execute(
			array(
				':id_shift_type' => $report->get_id_shift_type(),
				':name' => $report->get_name(),
				':route' => $report->get_route(),
				':book' => $report->get_book(),
				':brochure' => $report->get_brochure(),
				':bible' => $report->get_bible(),
				':magazine' => $report->get_magazine(),
				':tract' => $report->get_tract(),
				':address' => $report->get_address(),
				':talk' => $report->get_talk(),
				':note_user' => $report->get_note_user(),
				':shift_datetime_from' => $report->get_shift_from()->format('Y-m-d H:i:s')
			)
		) && $stmt->rowCount() == 1;
	}

	static function delete(\PDO $connection, int $id_report): bool {
		$stmt = $connection->prepare(
			'DELETE FROM ' . self::TABLE_NAME . ' WHERE id_report = :id_report'
		);

		return $stmt->execute(
			array(':id_report' => $id_report)
		);
	}

	static function delete_old_entries(\PDO $connection): bool {
		$sql = 'DELETE FROM ' . self::TABLE_NAME . ' WHERE DATE(shift_datetime_from) < date("now", "-2 years")';
		return ($connection->exec($sql) === false)? false : true;
	}
}