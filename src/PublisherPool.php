<?php
namespace App;

use PhpPages\StorageVeil;

class PublisherPool implements PublisherPoolInterface
{
    private \PDO $sqlite;

    function __construct(\PDO $sqlite)
    {
        $this->sqlite = $sqlite;        
    }

    function all(string $orderBy, string $sort): \Iterator
    {
        $stmt = $this->sqlite->query(
            <<<SQL
                SELECT
                    id, username, email, first_name, last_name,
                    administrative, active, phone, mobile, congregation,
                    language, user_note, admin_note, logged_on, updated_on, created_on
                FROM user
                ORDER BY {$orderBy} {$sort}
            SQL
        );
        
        foreach ($stmt->getIterator() as $user) {
            yield new StorageVeil(
                new Publisher(
                    $this->sqlite,
                    $user['id']
                ),
                $this->convertUserToStorageVeil($user)
            );
        }
    }

    function allByNameOrEmail(string $nameOrEmail, string $orderBy, string $sort): \Generator
    {
        $stmt = $this->sqlite->prepare(
            <<<SQL
                SELECT
                    id, username, email, first_name, last_name,
                    administrative, active, phone, mobile, congregation,
                    language, user_note, admin_note, logged_on, updated_on, created_on
                FROM user
                WHERE email LIKE :email
                OR first_name LIKE :firstName
                OR last_name LIKE :lastName
                ORDER BY {$orderBy} {$sort}
            SQL
        );

        $stmt->execute([
            'email' => '%' . $nameOrEmail . '%',
            'firstName' => '%' . $nameOrEmail . '%',
            'lastName' => '%' . $nameOrEmail . '%'
        ]);

        foreach ($stmt->getIterator() as $user) {
            yield new StorageVeil(
                new Publisher(
                    $this->sqlite,
                    $user['id']
                ),
                $this->convertUserToStorageVeil($user)
            );
        }
    }

    function publisher(int $id): StorageVeil
    {
        $stmt = $this->sqlite->prepare(
            <<<'SQL'
                SELECT
                    id, username, email, first_name, last_name,
                    administrative, active, phone, mobile, congregation,
                    language, user_note, admin_note, logged_on, updated_on, created_on
                FROM user
                WHERE id = :id
            SQL
        );

        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        if ($user) {
            return new StorageVeil(
                new Publisher(
                    $this->sqlite,
                    $user['id']
                ),
                $this->convertUserToStorageVeil($user)
            );
        }

        return new StorageVeil(
            new Anonymous(),
            []
        );
    }

    function publisherActiveByUsernameOrEmailAndPassword(string $usernameOrEmail, string $password): StorageVeil
    {
        $stmt = $this->sqlite->prepare(
            <<<'SQL'
                SELECT id, username
                FROM user
                WHERE (email = :email OR username = :username)
                AND password = :password
                AND active = 1
            SQL
        );

        $stmt->execute([
            'email' => $usernameOrEmail,
            'username' => $usernameOrEmail,
            'password' => md5($password)
        ]);

        $user = $stmt->fetch();
        
        if ($user) {
            return new StorageVeil(
                new Publisher(
                    $this->sqlite,
                    $user['id']
                ),
                [
                    'username' => $user['username']
                ]
            );
        }

        return new StorageVeil(
            new Anonymous(),
            []
        );
    }

    private function convertUserToStorageVeil(array $user): array
    {
        return [
            'active' => (bool)$user['active'],
            'administrative' =>  (bool)$user['administrative'],
            'adminNote' => $user['admin_note'],
            'createdOn' => new \DateTimeImmutable($user['created_on']),
            'congregation' => $user['congregation'],
            'email' => $user['email'],
            'firstName' => $user['first_name'],
            'language' => $user['language'],
            'lastName' => $user['last_name'],
            'loggedOn' => (empty($user['logged_on']))? new \DateTimeImmutable('0000-01-01') : new \DateTimeImmutable($user['logged_on']),
            'mobile' => $user['mobile'],
            'phone' => $user['phone'],
            'updatedOn' => new \DateTimeImmutable($user['updated_on']),
            'username' => $user['username'],
            'userNote' => $user['user_note']
        ];
    }
}