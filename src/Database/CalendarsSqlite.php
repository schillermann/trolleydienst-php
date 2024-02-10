<?php

namespace App\Database;

class CalendarsSqlite
{
  private \PDO $pdo;

  function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }
  function shiftType(int $shiftTypeId): CalendarSqlite
  {
    $stmt = $this->pdo->prepare(<<<SQL
        SELECT id_shift_type, name, user_per_shift_max, info, updated AS last_modified_on, created AS created_on
        FROM shift_types
        WHERE id_shift_type = :shiftTypeId
    SQL);
    $stmt->execute([
      'shiftTypeId' => $shiftTypeId
    ]);
    $shiftType = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($shiftType === false) {
      return new CalendarSqlite(0);
    }

    return new CalendarSqlite(
      $shiftType['id_shift_type'],
      $shiftType
    );
  }
}
