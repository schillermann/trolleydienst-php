<?php

namespace App\Database;

class CalendarsSqlite
{
  private \PDO $pdo;

  function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  function add(string $name, string $info, int $publishersPerShift): int
  {
    $stmt = $this->pdo->prepare(<<<SQL
      INSERT INTO shift_types (name, user_per_shift_max, info, updated, created)
      VALUES (:name, :publishersPerShift, :info, datetime("now", "localtime"), datetime("now", "localtime"))
    SQL);

    $stmt->execute([
      'name' =>  $name,
      'info' => $info,
      'publishersPerShift' => $publishersPerShift,
    ]);

    return (int)$this->pdo->lastInsertId();
  }

  function all(int $offset, int $limit): \Generator
  {
    $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift_type AS id, name, user_per_shift_max AS publishers_per_shift, info, updated AS updated_on, created AS created_on
            FROM shift_types
            LIMIT :offset, :limit
        SQL);

    $stmt->execute([
      'offset' => $offset,
      'limit' => $limit
    ]);

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $calendar) {
      yield new CalendarSqlite(
        $calendar["id"],
        $calendar
      );
    }
  }

  function calendar(int $calendarId): CalendarSqlite
  {
    $stmt = $this->pdo->prepare(<<<SQL
        SELECT id_shift_type AS id, name, user_per_shift_max AS publishers_per_shift, info, updated AS updated_on, created AS created_on
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

  public function delete(int $calendarId): bool
  {
    $stmt = $this->pdo->prepare(<<<SQL
      DELETE FROM shift_types
      WHERE id_shift_type = :calendarId
    SQL);

    return $stmt->execute(
      [':calendarId' => $calendarId]
    );
  }

  public function update(
    int $calendarId,
    string $name,
    string $info,
    int $publishersPerShift,
  ): bool {
    $stmt = $this->pdo->prepare(<<<SQL
      UPDATE shift_types
      SET name = :name, user_per_shift_max = :publishersPerShift, info = :info, updated = datetime("now", "localtime")
      WHERE id_shift_type = :calendarId
    SQL);

    $stmt->execute([
      'name' => $name,
      'publishersPerShift' => $publishersPerShift,
      'info' => $info,
      'calendarId' => $calendarId
    ]);

    return $stmt->rowCount() == 1;
  }
}
