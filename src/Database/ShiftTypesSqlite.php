<?php

namespace App\Database;

class ShiftTypesSqlite
{
  private \PDO $pdo;

  function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }
  function shiftType(int $shiftTypeId): ShiftTypeSqlite
  {
    $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift_type, name, user_per_shift_max, info, updated, created FROM shift_types WHERE id_shift_type = :shiftTypeId
        SQL);
    $stmt->execute([
      'shiftTypeId' => $shiftTypeId
    ]);
    $shiftType = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($shiftType === false) {
      return new ShiftTypeSqlite(0);
    }

    return new ShiftTypeSqlite(
      $shiftType['id_shift_type'],
      $shiftType
    );
  }
}
