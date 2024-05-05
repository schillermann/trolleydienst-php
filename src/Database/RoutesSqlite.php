<?php

namespace App\Database;

use App\Shift\HexColorCode;

class RoutesSqlite
{
  private \PDO $pdo;
  private int $calendarId;

  function __construct(\PDO $pdo, int $calendarId)
  {
    $this->pdo = $pdo;
    $this->calendarId = $calendarId;
  }

  public function add(\DateTimeInterface $start, string $routeName, int $numberOfShifts, int $minutesPerShift, string $color): int
  {
    $stmt = $this->pdo->prepare(<<<SQL
      INSERT INTO shifts (id_shift_type, route, datetime_from, number, minutes_per_shift, color_hex, updated, created)
      VALUES (:calendarId, :routeName, :start, :numberOfShifts, :minutesPerShift, :color, datetime("now", "localtime"), datetime("now", "localtime"))
    SQL);

    $stmt->execute([
      'calendarId' => $this->calendarId,
      'routeName' =>  $routeName,
      'start' => $start->format('Y-m-d H:i'),
      'numberOfShifts' => $numberOfShifts,
      'minutesPerShift' => $minutesPerShift,
      "color" => $color
    ]);

    return (int)$this->pdo->lastInsertId();
  }

  function route(int $routeId): RouteSqlite
  {
    $stmt = $this->pdo->prepare(<<<SQL
      SELECT id_shift AS id, id_shift_type AS calendar_id, route, datetime_from, number AS number_of_shifts, minutes_per_shift, color_hex AS color, updated AS updated_on, created AS created_on
      FROM shifts
      WHERE id_shift = :routeId
    SQL);
    $stmt->execute([
      'routeId' => $routeId
    ]);
    $route = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($route === false) {
      return new RouteSqlite(0);
    }

    return new RouteSqlite(
      $route['id'],
      $route,
    );
  }

  public function routesFrom(\DateTimeInterface $start, int $pageNumber, int $pageItems): \Generator
  {
    $stmt = $this->pdo->prepare(<<<SQL
      SELECT id_shift AS id, id_shift_type AS calendar_id, route, datetime_from, number AS number_of_shifts, minutes_per_shift, color_hex AS color, updated AS updated_on, created AS created_on
      FROM shifts
      WHERE datetime_from > :from AND id_shift_type = :calendarId
      ORDER BY datetime_from ASC
      LIMIT :offset, :limit
    SQL);

    $stmt->execute([
      'from' => $start->format('Y-m-d'),
      'calendarId' => $this->calendarId,
      'offset' => ($pageNumber - 1) * $pageItems,
      'limit' => $pageItems,
    ]);
    $stmt->setFetchMode(\PDO::FETCH_ASSOC);

    foreach ($stmt as $route) {
      yield new RouteSqlite(
        $route['id'],
        $route,
      );
    }
  }

  public function shiftsTotalNumber(\DateTimeInterface $start): int
  {
    $stmt = $this->pdo->prepare(<<<SQL
      SELECT count(*)
      FROM shifts
      WHERE datetime_from > :from AND id_shift_type = :calendarId
    SQL);
    $stmt->execute([
      'from' => $start->format('Y-m-d'),
      'calendarId' => $this->calendarId,
    ]);

    return $stmt->fetchColumn();
  }

  public function update(
    int $routeId,
    \DateTimeImmutable $start,
    string $routeName,
    int $numberOfShifts,
    int $minutesPerShift,
    string $color
  ): bool {
    $stmt = $this->pdo->prepare(<<<SQL
      UPDATE shifts
      SET route = :routeName, datetime_from = :start, number = :numberOfShifts, minutes_per_shift = :minutesPerShift, color_hex = :color, updated = datetime("now", "localtime")
      WHERE id_shift = :routeId AND id_shift_type = :calendarId
    SQL);

    $stmt->execute([
      'routeName' => $routeName,
      'start' => $start->format('Y-m-d H:i:s'),
      'numberOfShifts' => $numberOfShifts,
      'minutesPerShift' => $minutesPerShift,
      'color' => $color,
      'routeId' => $routeId,
      'calendarId' => $this->calendarId
    ]);

    return $stmt->rowCount() == 1;
  }
}
