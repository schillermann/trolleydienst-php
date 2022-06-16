<?php
namespace App\Tables;

class Users {

    const TABLE_NAME = 'users';

    static function create_table(\PDO $connection): bool {

        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
                `id_user` INTEGER PRIMARY KEY AUTOINCREMENT,
                `username` TEXT NOT NULL UNIQUE,
                `name` TEXT NOT NULL,
                `email` TEXT NOT NULL,
                `password` TEXT NOT NULL,
                `phone` TEXT DEFAULT NULL,
                `mobile` TEXT DEFAULT NULL,
                `congregation_name` TEXT DEFAULT NULL,
                `language` TEXT DEFAULT NULL,
                `note_user`	TEXT,
                `note_admin` TEXT,
                `is_active` INTEGER DEFAULT 1,
                `is_admin` INTEGER DEFAULT 0,
                `last_login` TEXT DEFAULT NULL,
                `updated` TEXT NOT NULL,
                `created` TEXT NOT NULL
			)';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function exists_username(\PDO $connection, string $username): bool {
        $stmt = $connection->prepare(
            'SELECT username FROM ' . self::TABLE_NAME . ' WHERE username = :username'
        );

        $stmt->execute(
            array(':username' => $username)
        );
        return (bool)$stmt->rowCount();
    }

    static function select_all(\PDO $connection): array {
        $stmt = $connection->query(
            'SELECT id_user, name, email, is_admin, is_active, last_login
            FROM ' . self::TABLE_NAME
        );
        $user_list = $stmt->fetchAll();
        return ($user_list === false)? array() : $user_list;
    }

    static function select_all_email(\PDO $connection): array {

        $stmt = $connection->query(
            'SELECT name, email FROM ' . self::TABLE_NAME . ' WHERE is_active = 1 '
        );

        $name_email_list = $stmt->fetchAll();
        return ($name_email_list === false)? array() : $name_email_list;
    }

    static function select_all_without_user(\PDO $connection, int $id_user): array {
        $stmt = $connection->prepare(
            'SELECT id_user, name
            FROM ' . self::TABLE_NAME . '
            WHERE id_user <> :id_user
            AND is_active = 1
            ORDER BY name');

        if(!$stmt->execute(
            array(':id_user' => $id_user)
        ))
        	return array();
        $user_list = $stmt->fetchAll();
        return ($user_list === false)? array() : $user_list;
    }

    static function select_user(\PDO $connection, int $id_user): array {

        $stmt = $connection->prepare(
            'SELECT username, name, email, phone, mobile, congregation_name,
            language, note_admin, note_user, is_active, is_admin, updated, created
            FROM ' . self::TABLE_NAME . '
            WHERE id_user = :id_user'
        );

        if(!$stmt->execute(
            array(':id_user' => $id_user)
        ))
        	return array();
        $user = $stmt->fetch();
        return ($user === false)? array() : $user;
    }

    static function select_name(\PDO $connection, int $id_user): string {

        $stmt = $connection->prepare(
            'SELECT name
            FROM ' . self::TABLE_NAME . '
            WHERE id_user = :id_user'
        );

        if(!$stmt->execute(
            array(':id_user' => $id_user)
        ))
        	return array();
        $name = $stmt->fetchColumn();
        return ($name)? $name : '';
    }

    static function select_email(\PDO $connection, int $id_user): string {

        $stmt = $connection->prepare(
            'SELECT email
            FROM ' . self::TABLE_NAME . '
            WHERE id_user = :id_user'
        );

        if(!$stmt->execute(
            array(':id_user' => $id_user)
        ))
            return array();
        $email = $stmt->fetchColumn();
        return ($email)? $email : '';
    }

    static function select_id_user(\PDO $connection, string $email, string $username): int {
        $stmt = $connection->prepare(
            'SELECT id_user
            FROM ' . self::TABLE_NAME . '
            WHERE email = :email
            AND username = :username'
        );

        if(!$stmt->execute(
            array(
                ':email' => $email,
                ':username' => $username
            )
        ))
        	return 0;
        $user_id = $stmt->fetchColumn();

        return ($user_id === false)? 0 : $user_id;
    }

    static function select_profile(\PDO $connection, int $id_user): array {

        $stmt = $connection->prepare(
            'SELECT username, name, email, phone, mobile, congregation_name, language, note_user
            FROM ' . self::TABLE_NAME . '
            WHERE id_user = :id_user'
        );

        if(!$stmt->execute(
            array(':id_user' => $id_user)
        ))
        	return array();
        $profile = $stmt->fetch();
        return ($profile === false)? array() : $profile;
    }

    static function select_logindata(\PDO $connection, string $email_or_username, string $password): array {
        $stmt = $connection->prepare(
            'SELECT id_user, name, is_admin
            FROM ' . self::TABLE_NAME . '
            WHERE (email = :email OR username = :username)
            AND password = :password
            AND is_active = 1'
        );

        $params = [
            ':email' => $email_or_username,
            ':username' => $email_or_username,
            ':password' => md5($password)
        ];

        if(!$stmt->execute($params)) {
            return [];
        }

        $logindata = $stmt->fetch();
        return ($logindata === false)? [] : $logindata;
    }

    static function update_login_time(\PDO $connection, int $id_user): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET last_login = datetime("now", "localtime")
            WHERE id_user = :id_user'
        );

        return $stmt->execute(
            array(':id_user' => $id_user)
        ) && $stmt->rowCount() == 1;
    }

    static function update_profile(\PDO $connection, \App\Models\Profile $profile): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET username = :username, name = :name, email = :email, phone = :phone, mobile = :mobile,
            congregation_name = :congregation_name, language = :language,
            note_user = :note_user, updated = datetime("now", "localtime")
            WHERE id_user = :id_user'
        );

        return $stmt->execute(
            [
                ':username' => $profile->get_username(),
                ':name' => $profile->get_name(),
                ':email' => $profile->get_email(),
                ':phone' => $profile->get_phone(),
                ':mobile' => $profile->get_mobile(),
                ':congregation_name' => $profile->get_congregation_name(),
                ':language' => $profile->get_language(),
                ':note_user' => $profile->get_note_user(),
                ':id_user' => $profile->get_id_user()
            ]
        ) && $stmt->rowCount() == 1;
    }

    static function update_user(\PDO $connection, \App\Models\User $user): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET  username = :username, name = :name, email = :email, is_active = :is_active, is_admin = :is_admin,
            phone = :phone, mobile = :mobile, congregation_name = :congregation_name,
            language = :language, note_admin = :note_admin, updated = datetime("now", "localtime")
            WHERE id_user = :id_user'
        );

	    return $stmt->execute(
            [
                ':username' => $user->get_username(),
                ':name' => $user->get_name(),
                ':email' => $user->get_email(),
                ':is_active' => (int)$user->is_active(),
                ':is_admin' => (int)$user->is_admin(),
                ':phone' => $user->get_phone(),
                ':mobile' => $user->get_mobile(),
                ':congregation_name' => $user->get_congregation_name(),
                ':language' => $user->get_language(),
                ':note_admin' => $user->get_note_admin(),
                ':id_user' => $user->get_id_user()
            ]
        ) && $stmt->rowCount() == 1;
    }

    static function update_password(\PDO $connection, int $id_user, string $password): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET password = :password, updated = datetime("now", "localtime")
            WHERE id_user = :id_user'
        );

		return $stmt->execute(
            array(
                ':password' => md5($password),
                ':id_user' => $id_user
            )
        ) && $stmt->rowCount() == 1;
    }

    static function insert(\PDO $connection, \App\Models\User $user): bool {

        $stmt = $connection->prepare(
            'INSERT INTO ' . self::TABLE_NAME . '
            (
                username, name, email, password, phone, mobile, congregation_name,
                language, note_admin, is_active, is_admin, updated, created
            )
            VALUES (
                :username, :name, :email, :password, :phone, :mobile, :congregation_name, :language,
                :note_admin, :is_active, :is_admin, datetime("now", "localtime"), datetime("now", "localtime")
            )'
        );

        return $stmt->execute(
            [
                ':username' => $user->get_username(),
                ':name' => $user->get_name(),
                ':email' => $user->get_email(),
                ':password' => md5($user->get_password()),
                ':phone' => $user->get_phone(),
                ':mobile' => $user->get_mobile(),
                ':congregation_name' => $user->get_congregation_name(),
                ':language' => $user->get_language(),
                ':note_admin' => $user->get_note_admin(),
                ':is_admin' => (int)$user->is_admin(),
                ':is_active' => (int)$user->is_active()
            ]
        ) && $stmt->rowCount() == 1;
    }

    static function delete(\PDO $connection, int $id_user): bool {
        $stmt = $connection->prepare(
            'DELETE FROM ' . self::TABLE_NAME . ' WHERE id_user = :id_user'
        );

        return $stmt->execute(
            array(':id_user' => $id_user)
        );
    }
}