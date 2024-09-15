<?php

namespace App\Database;

class PublishersSqlite
{
  private \PDO $pdo;

  function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  function add(
    bool $active,
    bool $admin,
    string $firstname,
    string $lastname,
    string $username,
    string $email,
    string $mobile,
    string $phone,
    string $congregation,
    string $languages,
    string $publisherNote,
    string $adminNote,
    string $password
  ): int {
    $stmt = $this->pdo->prepare(<<<SQL
      INSERT INTO publisher (active, administrative, first_name, last_name, username, email, mobile, phone, congregation, language, publisher_note, admin_note, password, updated_on, created_on)
      VALUES (:active, :admin, :firstname, :lastname, :username, :email, :mobile, :phone, :congregation, :languages, :publisherNote, :adminNote, :password, datetime("now", "localtime"), datetime("now", "localtime"))
    SQL);

    $stmt->execute([
      'active' => $active,
      'admin' => $admin,
      'firstname' => $firstname,
      'lastname' => $lastname,
      'username' => $username,
      'email' => $email,
      'mobile' =>  $mobile,
      'phone' => $phone,
      'congregation' => $congregation,
      'languages' => $languages,
      'publisherNote' => $publisherNote,
      'adminNote' => $adminNote,
      'password' => md5($password)
    ]);

    return (int)$this->pdo->lastInsertId();
  }

  function publisher(int $publisherId): PublisherSqlite
  {
    $stmt = $this->pdo->prepare(<<<SQL
            SELECT id, username, first_name AS firstname, last_name AS lastname, email, phone, mobile, congregation, language AS languages, publisher_note, admin_note, active, administrative AS admin, logged_on, updated_on AS last_modified_on, created_on
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
            SELECT id, username, first_name AS firstname, last_name AS lastname, email, phone, mobile, congregation, language AS languages, publisher_note, admin_note, active, administrative AS admin, logged_on, updated_on, created_on
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

  function publishersByNameOrEmail(int $offset, int $limit, string $searchNameOrEmail): \Generator
  {
    $stmt = $this->pdo->prepare(<<<SQL
      SELECT id, username, first_name AS firstname, last_name AS lastname, email, phone, mobile, congregation, language as languages, publisher_note, admin_note, active, administrative AS admin, logged_on, updated_on, created_on
      FROM publisher
      WHERE first_name LIKE :searchNameOrEmail OR last_name LIKE :searchNameOrEmail OR email LIKE :searchNameOrEmail
      LIMIT :offset, :limit
    SQL);

    $stmt->execute([
      'offset' => $offset,
      'limit' => $limit,
      'searchNameOrEmail' => '%' . $searchNameOrEmail . '%'
    ]);

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $publisher) {
      yield new PublisherSqlite(
        $publisher["id"],
        $publisher
      );
    }
  }

  function publishersFilterActive(int $offset, int $limit): \Generator
  {
    $stmt = $this->pdo->prepare(<<<SQL
            SELECT id, username, first_name AS firstname, last_name AS lastname, email, phone, mobile, congregation, language as languages, publisher_note, admin_note, active, administrative AS admin, logged_on, updated_on, created_on
            FROM publisher
            WHERE active = 1
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

  function publishersTotalNumber(): int
  {
    $stmt = $this->pdo->prepare(<<<SQL
            SELECT count(*)
            FROM publisher
        SQL);
    $stmt->execute();

    return $stmt->fetchColumn();
  }

  function update(
    int $publisherId,
    bool $active,
    bool $admin,
    string $firstname,
    string $lastname,
    string $username,
    string $email,
    string $mobile,
    string $phone,
    string $congregation,
    string $languages,
    string $publisherNote,
    string $adminNote
  ): bool {
    $stmt = $this->pdo->prepare(<<<SQL
      UPDATE publisher
      SET active = :active, administrative = :admin, first_name = :firstname, last_name = :lastname, username = :username, email = :email, mobile = :mobile, phone = :phone, congregation = :congregation, language = :languages, publisher_note = :publisherNote, admin_note = :adminNote, updated_on = datetime("now", "localtime")
      WHERE id = :publisherId
    SQL);

    $stmt->execute([
      'active' => (int)$active,
      'admin' => (int)$admin,
      'firstname' => $firstname,
      'lastname' => $lastname,
      'username' => $username,
      'email' => $email,
      'mobile' => $mobile,
      'phone' => $phone,
      'congregation' => $congregation,
      'languages' => $languages,
      'publisherId' => $publisherId,
      'publisherNote' => $publisherNote,
      'adminNote' => $adminNote
    ]);

    return $stmt->rowCount() == 1;
  }

  public function delete(int $publisherId): bool
  {
    $stmt = $this->pdo->prepare(<<<SQL
      DELETE FROM publisher
      WHERE id = :publisherId
    SQL);

    return $stmt->execute(
      [':publisherId' => $publisherId]
    );
  }
}
