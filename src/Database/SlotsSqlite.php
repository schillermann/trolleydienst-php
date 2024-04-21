<?php

namespace App\Database;

class SlotsSqlite
{
  private \PDO $pdo;

  function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  function slot(int $routeId, int $shiftNumber, int $publisherId): SlotSqlite
  {

    $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift AS route_id, id_user AS publisher_id, position AS shift_number, created AS created_on
            FROM shift_user_maps
            WHERE id_shift = :routeId AND id_user = :publisherId AND position = :shiftNumber
        SQL);
    $stmt->execute([
      'routeId' => $routeId,
      'publisherId' => $publisherId,
      'shiftNumber' => $shiftNumber
    ]);
    $slot = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($slot === false) {
      return new SlotSqlite();
    }

    return new SlotSqlite(
      $slot
    );
  }

  function slots(int $routeId, int $shiftNumber): \Generator
  {
    $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift AS route_id, id_user AS publisher_id, position AS shift_number, created AS created_on, first_name AS firstname, last_name AS lastname
            FROM shift_user_maps
            LEFT JOIN publisher ON shift_user_maps.id_user = publisher.id
            WHERE id_shift = :routeId AND position = :shiftNumber
            ORDER BY shift_number  ASC
        SQL);
    $stmt->execute([
      'routeId' => $routeId,
      'shiftNumber' => $shiftNumber
    ]);

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $slot) {
      yield new SlotSqlite($slot);
    }
  }

  function add(int $routeId, int $shiftNumber, int $publisherId): void
  {
    $stmt = $this->pdo->prepare(<<<SQL
            INSERT INTO shift_user_maps (id_shift, position, id_user, created)
            VALUES (:routeId, :shiftNumber, :publisherId, datetime("now", "localtime"))
        SQL);

    $stmt->execute([
      'routeId' => $routeId,
      'shiftNumber' => $shiftNumber,
      'publisherId' => $publisherId
    ]);
  }

  function releaseSlot(int $routeId, int $shiftNumber, int $publisherId): void
  {
    $stmt = $this->pdo->prepare(<<<SQL
            DELETE FROM shift_user_maps
            WHERE id_shift = :routeId AND position = :shiftNumber AND id_user = :publisherId
        SQL);

    $stmt->execute([
      'routeId' => $routeId,
      'shiftNumber' => $shiftNumber,
      'publisherId' => $publisherId
    ]);
  }
}
