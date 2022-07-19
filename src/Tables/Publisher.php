<?php

namespace App\Tables;

class Publisher
{

    const TABLE_NAME = 'publisher';

    static function create_table(\PDO $connection): bool
    {

        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
                `id` INTEGER PRIMARY KEY AUTOINCREMENT,
                `username` TEXT NOT NULL UNIQUE,
                `first_name` TEXT NOT NULL,
                `last_name` TEXT NOT NULL,
                `email` TEXT NOT NULL,
                `password` TEXT NOT NULL,
                `phone` TEXT DEFAULT NULL,
                `mobile` TEXT DEFAULT NULL,
                `congregation` TEXT DEFAULT NULL,
                `language` TEXT DEFAULT NULL,
                `publisher_note`	TEXT,
                `admin_note` TEXT,
                `active` INTEGER DEFAULT 1,
                `administrative` INTEGER DEFAULT 0,
                `logged_on` TEXT DEFAULT NULL,
                `updated_on` TEXT NOT NULL,
                `created_on` TEXT NOT NULL
			)';

        return ($connection->exec($sql) === false) ? false : true;
    }

    static function exists_username(\PDO $connection, string $username): bool
    {
        $stmt = $connection->prepare(
            'SELECT username FROM ' . self::TABLE_NAME . ' WHERE username = :username'
        );

        $stmt->execute(
            array(':username' => $username)
        );
        return (bool)$stmt->rowCount();
    }

    static function select_all(\PDO $connection): array
    {
        $stmt = $connection->query(
            'SELECT id, first_name, last_name, email, administrative, active, logged_on
            FROM ' . self::TABLE_NAME
        );
        $user_list = $stmt->fetchAll();
        return ($user_list === false) ? array() : $user_list;
    }
    static function select_user_search_name(\PDO $connection, $search_name = ""): array
    {
        $stmt = $connection->query(
            'SELECT id, first_name, last_name, email, administrative, active, logged_on
            FROM ' . self::TABLE_NAME
        );
        if (!empty($search_name)) {
            $stmt = $connection->query(
                'SELECT id, first_name, last_name, email, administrative, active, logged_on
                FROM ' . self::TABLE_NAME . ' WHERE first_name LIKE :search_name OR last_name LIKE :search_name OR email LIKE :search_name'
            );
            if (!$stmt->execute(
                array(':search_name' => '%' . $search_name . '%')
            ))

                return array();
        }
        $user_list = $stmt->fetchAll();
        return ($user_list === false) ? array() : $user_list;
    }
    static function select_all_email(\PDO $connection): array
    {

        $stmt = $connection->query(
            'SELECT first_name, last_name, email FROM ' . self::TABLE_NAME . ' WHERE active = 1 '
        );

        $name_email_list = $stmt->fetchAll();
        return ($name_email_list === false) ? array() : $name_email_list;
    }

    static function select_all_without_user(\PDO $connection, int $id_user): array
    {
        $stmt = $connection->prepare(
            'SELECT id, first_name || \' \' || last_name AS name
            FROM ' . self::TABLE_NAME . '
            WHERE id <> :id
            AND active = 1
            ORDER BY first_name'
        );

        if (!$stmt->execute(
            array(':id' => $id_user)
        ))
            return array();
        $user_list = $stmt->fetchAll();
        return ($user_list === false) ? array() : $user_list;
    }

    static function select_user(\PDO $connection, int $id_user): array
    {

        $stmt = $connection->prepare(
            'SELECT username, first_name, last_name, email, phone, mobile, congregation,
            language, admin_note, publisher_note, active, administrative,  updated_on, created_on
            FROM ' . self::TABLE_NAME . '
            WHERE id = :id'
        );

        if (!$stmt->execute(
            array(':id' => $id_user)
        ))
            return array();
        $user = $stmt->fetch();
        return ($user === false) ? array() : $user;
    }

    static function select_name(\PDO $connection, int $id_user): string
    {

        $stmt = $connection->prepare(
            'SELECT first_name || \' \' || last_name
            FROM ' . self::TABLE_NAME . '
            WHERE id = :id'
        );

        if (!$stmt->execute(
            array(':id' => $id_user)
        ))
            return array();
        $name = $stmt->fetchColumn();
        return ($name) ? $name : '';
    }

    static function select_email(\PDO $connection, int $id_user): string
    {

        $stmt = $connection->prepare(
            'SELECT email
            FROM ' . self::TABLE_NAME . '
            WHERE id = :id'
        );

        if (!$stmt->execute(
            array(':id' => $id_user)
        ))
            return array();
        $email = $stmt->fetchColumn();
        return ($email) ? $email : '';
    }

    static function select_id_user(\PDO $connection, string $email, string $username): int
    {
        $stmt = $connection->prepare(
            'SELECT id
            FROM ' . self::TABLE_NAME . '
            WHERE email = :email
            AND username = :username'
        );

        if (!$stmt->execute(
            array(
                ':email' => $email,
                ':username' => $username
            )
        ))
            return 0;
        $user_id = $stmt->fetchColumn();

        return ($user_id === false) ? 0 : $user_id;
    }

    static function select_profile(\PDO $connection, int $id_user): array
    {

        $stmt = $connection->prepare(
            'SELECT username, first_name, last_name, email, phone, mobile, congregation, language, publisher_note
            FROM ' . self::TABLE_NAME . '
            WHERE id = :id'
        );

        if (!$stmt->execute(
            array(':id' => $id_user)
        ))
            return array();
        $profile = $stmt->fetch();
        return ($profile === false) ? array() : $profile;
    }

    static function select_logindata(\PDO $connection, string $email_or_username, string $password): array
    {
        $stmt = $connection->prepare(
            'SELECT id, first_name, last_name, administrative
            FROM ' . self::TABLE_NAME . '
            WHERE (email = :email OR username = :username)
            AND password = :password
            AND active = 1'
        );

        $params = [
            ':email' => $email_or_username,
            ':username' => $email_or_username,
            ':password' => md5($password)
        ];

        if (!$stmt->execute($params)) {
            return [];
        }

        $logindata = $stmt->fetch();
        return ($logindata === false) ? [] : $logindata;
    }

    static function update_login_time(\PDO $connection, int $id_user): bool
    {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET logged_on = datetime("now", "localtime")
            WHERE id = :id'
        );

        return $stmt->execute(
            array(':id' => $id_user)
        ) && $stmt->rowCount() == 1;
    }

    static function update_profile(\PDO $connection, \App\Models\Profile $profile): bool
    {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET username = :username, first_name = :first_name, last_name = :last_name, email = :email, phone = :phone, mobile = :mobile,
            congregation = :congregation, language = :language,
            publisher_note = :publisher_note,  updated_on = datetime("now", "localtime")
            WHERE id = :id'
        );

        return $stmt->execute(
            [
                ':username' => $profile->get_username(),
                ':first_name' => $profile->get_firstName(),
                ':last_name' => $profile->get_lastName(),
                ':email' => $profile->get_email(),
                ':phone' => $profile->get_phone(),
                ':mobile' => $profile->get_mobile(),
                ':congregation' => $profile->get_congregation(),
                ':language' => $profile->get_language(),
                ':publisher_note' => $profile->get_publisher_note(),
                ':id' => $profile->get_id_user()
            ]
        ) && $stmt->rowCount() == 1;
    }

    static function update_user(\PDO $connection, \App\Models\User $user): bool
    {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET  username = :username, first_name = :first_name, last_name = :last_name, email = :email, active = :active, administrative = :administrative,
            phone = :phone, mobile = :mobile, congregation = :congregation,
            language = :language, admin_note = :admin_note,  updated_on = datetime("now", "localtime")
            WHERE id = :id'
        );

        return $stmt->execute(
            [
                ':username' => $user->get_username(),
                ':first_name' => $user->get_firstName(),
                ':last_name' => $user->get_lastName(),
                ':email' => $user->get_email(),
                ':active' => (int)$user->active(),
                ':administrative' => (int)$user->administrative(),
                ':phone' => $user->get_phone(),
                ':mobile' => $user->get_mobile(),
                ':congregation' => $user->get_congregation(),
                ':language' => $user->get_language(),
                ':admin_note' => $user->get_admin_note(),
                ':id' => $user->get_id_user()
            ]
        ) && $stmt->rowCount() == 1;
    }

    static function update_password(\PDO $connection, int $id_user, string $password): bool
    {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET password = :password,  updated_on = datetime("now", "localtime")
            WHERE id = :id'
        );

        return $stmt->execute(
            array(
                ':password' => md5($password),
                ':id' => $id_user
            )
        ) && $stmt->rowCount() == 1;
    }

    static function insert(\PDO $connection, \App\Models\User $user): bool
    {

        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . '
            (
                username, first_name, last_name, email, password, phone, mobile, congregation,
                language, admin_note, active, administrative,  updated_on, created_on
            )
            VALUES (
                :username, :first_name, :last_name, :email, :password, :phone, :mobile, :congregation, :language,
                :admin_note, :active, :administrative, datetime("now", "localtime"), datetime("now", "localtime")
            )'
        );

        return $stmt->execute(
            [
                ':username' => $user->get_username(),
                ':first_name' => $user->get_firstName(),
                ':last_name' => $user->get_lastName(),
                ':email' => $user->get_email(),
                ':password' => md5($user->get_password()),
                ':phone' => $user->get_phone(),
                ':mobile' => $user->get_mobile(),
                ':congregation' => $user->get_congregation(),
                ':language' => $user->get_language(),
                ':admin_note' => $user->get_admin_note(),
                ':administrative' => (int)$user->administrative(),
                ':active' => (int)$user->active()
            ]
        ) && $stmt->rowCount() == 1;
    }

    static function delete(\PDO $connection, int $id_user): bool
    {
        $stmt = $connection->prepare(
            'DELETE FROM ' . self::TABLE_NAME . ' WHERE id = :id'
        );

        return $stmt->execute(
            array(':id' => $id_user)
        );
    }
}
