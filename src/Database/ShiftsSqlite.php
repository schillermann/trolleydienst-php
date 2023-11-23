<?php

namespace App\Database;

class ShiftsSqlite
{
  private \PDO $pdo;

  function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  function addPublisher(int $shiftId, int $shiftPositionId, int $publisherId): void
  {
    $stmt = $this->pdo->prepare(<<<SQL
            INSERT INTO shift_user_maps (id_shift, position, id_user, created)
            VALUES (:shiftId, :shiftPosition, :publisherId, datetime("now", "localtime"))
        SQL);

    $stmt->execute([
      'shiftId' => $shiftId,
      'shiftPosition' => $shiftPositionId,
      'publisherId' => $publisherId
    ]);
  }

  function shift(int $shiftId)
  {
    $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift, id_shift_type, route, datetime_from, number, minutes_per_shift, color_hex, updated, created
            FROM shifts
            WHERE id_shift = :shiftId
        SQL);

    $stmt->execute([
      'shiftId' => $shiftId
    ]);

    $shift = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($shift === false) {
      return new ShiftSqlite(0);
    }

    return new ShiftSqlite(
      $shift['id_shift'],
      $shift,
    );
  }
}
