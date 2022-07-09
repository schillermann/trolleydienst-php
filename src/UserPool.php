<?php
namespace App;

class UserPool implements UserPoolInterface
{
    private \PDO $sqlite;

    function __construct(\PDO $sqlite)
    {
        $this->sqlite = $sqlite;        
    }

    function all(): \Iterator
    {
        $stmt = $this->sqlite->query(
            <<<'SQL'
                SELECT id_user, username, email, name, is_admin, is_active, phone, mobile, congregation_name, language, note_user, note_admin, last_login, updated, created
                FROM users
            SQL
        );
        foreach ($stmt->getIterator() as $user) {
            yield (new User(
                $user['id_user']
            ))
                ->withActive($user['is_active'])
                ->withAdministrative($user['is_admin'])
                ->withEmail($user['email'])
                ->withLoginAt((string)$user['last_login'])
                ->withName($user['name']);
        }
    }

    function user(int $id): UserInterface
    {
        $stmt = $this->sqlite->prepare(
            <<<'SQL'
                SELECT username, email, name, is_admin, is_active, phone, mobile, congregation_name, language, note_user, note_admin, last_login, updated, created
                FROM users
                WHERE id_user = :id_user
            SQL
        );

        $stmt->execute([':id_user' => $id]);
        $user = $stmt->fetch();

        if ($user) {
            return (new User($id))
                ->withActive($user['is_active'])
                ->withEmail($user['email']);
        }

        return  new UserAnonymous();
    }

    function userActiveByUsernameOrEmailAndPassword(string $usernameOrEmail, string $password): UserInterface
    {
        $stmt = $this->sqlite->prepare(
            <<<'SQL'
                SELECT id_user, username
                FROM users
                WHERE (email = :email OR username = :username)
                AND password = :password
                AND is_active = 1
            SQL
        );

        $stmt->execute([
            ':email' => $usernameOrEmail,
            ':username' => $usernameOrEmail,
            ':password' => md5($password)
        ]);

        $user = $stmt->fetch();
        
        if ($user) {
            return (new User(
                $user['id_user']
            ))
                ->withUsername($user['username']);
        }

        return  new UserAnonymous();
    }
}