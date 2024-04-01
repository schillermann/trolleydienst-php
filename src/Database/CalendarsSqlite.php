<?php

namespace App\Database;

class CalendarsSqlite
{
  private \PDO $pdo;

  function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  function calendar(int $calendarId): CalendarSqlite
  {
    $stmt = $this->pdo->prepare(<<<SQL
        SELECT id_shift_type AS id, name, user_per_shift_max, info, updated AS updated_on, created AS created_on
        FROM shift_types
        WHERE id_shift_type = :calendarId
    SQL);
    $stmt->execute([
      'calendarId' => $calendarId
    ]);
    $calendar = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($calendar === false) {
      return new CalendarSqlite(0);
    }

    return new CalendarSqlite(
      $calendar['id'],
      $calendar
    );
  }
}
