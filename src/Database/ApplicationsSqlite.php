<?php

namespace App\Database;

class ApplicationsSqlite
{
  private \PDO $pdo;

  function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  function application(int $shiftId, int $positionId, int $publisherId): ApplicationSqlite
  {

    $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift, id_user, position, created
            FROM shift_user_maps
            WHERE id_shift = :shiftId AND id_user = :publisherId AND position = :positionId
        SQL);
    $stmt->execute([
      'shiftId' => $shiftId,
      'publisherId' => $publisherId,
      'positionId' => $positionId
    ]);
    $application = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($application === false) {
      return new ApplicationSqlite(0, 0, 0);
    }

    return new ApplicationSqlite(
      $application['id_shift'],
      $application['id_user'],
      $application['position'],
      $application
    );
  }

  function applications(int $shiftId, int $positionId): \Generator
  {
    $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift, id_user, position, created
            FROM shift_user_maps
            WHERE id_shift = :shiftId AND position = :positionId
        SQL);

    $stmt->execute([
      'shiftId' => $shiftId,
      'positionId' => $positionId
    ]);
    $stmt->setFetchMode(\PDO::FETCH_ASSOC);

    foreach ($stmt as $application) {
      yield new ApplicationSqlite(
        $application['id_shift'],
        $application['id_user'],
        $application['position'],
        $application
      );
    }
  }

  function add(int $shiftId, int $shiftPositionId, int $publisherId): void
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

  function remove(int $shiftId, int $shiftPositionId, int $publisherId): void
  {
    $stmt = $this->pdo->prepare(<<<SQL
            DELETE FROM shift_user_maps
            WHERE id_shift = :shiftId AND position = :shiftPositionId AND id_user = :publisherId
        SQL);

    $stmt->execute([
      'shiftId' => $shiftId,
      'shiftPositionId' => $shiftPositionId,
      'publisherId' => $publisherId
    ]);
  }
}
