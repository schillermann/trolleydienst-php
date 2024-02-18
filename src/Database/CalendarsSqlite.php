<?php

namespace App\Database;

class CalendarsSqlite
{
  private \PDO $pdo;
  private int $calendarId;

  function __construct(\PDO $pdo, int $calendarId)
  {
    $this->pdo = $pdo;
    $this->calendarId = $calendarId;
  }
  function calendar(): CalendarSqlite
  {
    $stmt = $this->pdo->prepare(<<<SQL
        SELECT id_shift_type AS calendar_id, name, user_per_shift_max, info, updated AS last_modified_on, created AS created_on
        FROM shift_types
        WHERE id_shift_type = :calendarId
    SQL);
    $stmt->execute([
      'calendarId' => $this->calendarId
    ]);
    $shiftType = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($shiftType === false) {
      return new CalendarSqlite(0);
    }

    return new CalendarSqlite(
      $shiftType['calendar_id'],
      $shiftType
    );
  }
}
