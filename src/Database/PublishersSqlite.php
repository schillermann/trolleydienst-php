<?php

namespace App\Database;

class PublishersSqlite
{
  private \PDO $pdo;

  function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  function publisher(int $publisherId): PublisherSqlite
  {
    $stmt = $this->pdo->prepare(<<<SQL
            SELECT id, username, first_name, last_name, email, phone, mobile, congregation, language, publisher_note, admin_note, active, administrative, logged_on AS last_logged_on, updated_on AS last_modified_on, created_on
            FROM publisher
            WHERE id = :publisherId
        SQL);
    $stmt->execute([
      'publisherId' => $publisherId
    ]);
    $publisher = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($publisher === false) {
      return new PublisherSqlite(0);
    }

    return new PublisherSqlite(
      $publisher['id'],
      $publisher,
    );
  }

  function publishers(int $offset, int $limit): \Generator
  {
    $stmt = $this->pdo->prepare(<<<SQL
            SELECT id, username, first_name, last_name, email, phone, mobile, congregation, language, publisher_note, admin_note, active, administrative, logged_on, updated_on, created_on
            FROM publisher
            LIMIT :offset, :limit
        SQL);

    $stmt->execute([
      'offset' => $offset,
      'limit' => $limit
    ]);

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $publisher) {
      yield new PublisherSqlite(
        $publisher["id"],
        $publisher
      );
    }
  }

  public function publishersTotalNumber(): int
  {
    $stmt = $this->pdo->prepare(<<<SQL
            SELECT count(*)
            FROM publisher
        SQL);
    $stmt->execute();

    return $stmt->fetchColumn();
  }
}
