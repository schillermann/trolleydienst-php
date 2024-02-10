<?php

namespace App\Database;

use App\Shift\HexColorCode;

class ShiftsSqlite
{
  private \PDO $pdo;

  function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function add(\DateTimeInterface $start, int $shiftTypeId, string $routeName, int $numberOfShifts, int $minutesPerShift, HexColorCode $hexColorCode): void
  {
    $stmt = $this->pdo->prepare(<<<SQL
            INSERT INTO shifts (id_shift_type, route, datetime_from, number, minutes_per_shift, color_hex, updated, created)
            VALUES (:shiftTypeId, :routeName, :start, :numberOfShifts, :minutesPerShift, :color, datetime("now", "localtime"), datetime("now", "localtime"))
        SQL);

    $stmt->execute([
      'shiftTypeId' => $shiftTypeId,
      'routeName' =>  $routeName,
      'start' => $start->format('Y-m-d H:i'),
      'numberOfShifts' => $numberOfShifts,
      'minutesPerShift' => $minutesPerShift,
      "color" => $hexColorCode->string()
    ]);
  }

  function shift(int $shiftId): ShiftSqlite
  {
    $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift, id_shift_type, route, datetime_from, number, minutes_per_shift, color_hex, updated AS last_modified_on, created AS created_on
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

  public function shiftsFrom(\DateTimeInterface $start, int $shiftTypeId, int $pageNumber, int $pageItems): \Generator
  {
    $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift, id_shift_type, route, datetime_from, number, minutes_per_shift, color_hex, updated, created
            FROM shifts
            WHERE datetime_from > :from AND id_shift_type = :shiftTypeId
            ORDER BY datetime_from ASC
            LIMIT :offset, :limit
        SQL);

    $stmt->execute([
      'from' => $start->format('Y-m-d'),
      'shiftTypeId' => $shiftTypeId,
      'offset' => ($pageNumber - 1) * $pageItems,
      'limit' => $pageItems,
    ]);
    $stmt->setFetchMode(\PDO::FETCH_ASSOC);

    foreach ($stmt as $shift) {
      yield new ShiftSqlite(
        $shift['id_shift'],
        $shift,
      );
    }
  }

  public function shiftsTotalNumber(\DateTimeInterface $start, int $shiftTypeId): int
  {
    $stmt = $this->pdo->prepare(<<<SQL
            SELECT count(*)
            FROM shifts
            WHERE datetime_from > :from AND id_shift_type = :shiftTypeId
        SQL);
    $stmt->execute([
      'from' => $start->format('Y-m-d'),
      'shiftTypeId' => $shiftTypeId,
    ]);

    return $stmt->fetchColumn();
  }
}
