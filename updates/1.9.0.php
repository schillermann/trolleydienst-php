<?php return function (\PDO $connection): bool {
    $sql_users_bak = 'ALTER TABLE users RENAME TO users_backup';
    $sql_users_rollback = 'ALTER TABLE users_backup RENAME TO users';

    if($connection->exec($sql_users_bak) === false) {
        return false;
    }

    if(!App\Tables\Users::create_table($connection)) {
        $connection->exec($sql_users_rollback);
        return false;
    }

    $sql_user_list = 'SELECT id_user, name, email, password, phone, mobile, congregation_name,
        language, note_user, note_admin, is_active, is_admin, last_login, updated, created FROM users_backup';
    $sql_insert_user =
        'INSERT INTO users (
            id_user, name, email, password, phone, mobile, congregation_name,
            language, note_user, note_admin, is_active, is_admin, last_login, updated, created
        )
        VALUES (
            :id_user, :name, :email, :password, :phone, :mobile, :congregation_name,
            :language, :note_user, :note_admin, :is_active, :is_admin, :last_login, datetime("now", "localtime"), :created
        )';

    foreach($connection->query($sql_user_list) as $row) {

        $stmt = $connection->prepare($sql_insert_user);
        $is_error = !$stmt->execute(
            [
                'id_user' => $row['id_user'],
                ':name' => $row['name'],
                ':email' => $row['email'],
                ':password' => $row['password'],
                ':phone' => $row['phone'],
                ':mobile' => $row['mobile'],
                ':congregation_name' => $row['congregation_name'],
                ':language' => $row['language'],
                ':note_user' => $row['note_user'],
                ':note_admin' => $row['note_admin'],
                ':is_active' => $row['is_active'],
                ':is_admin' => $row['is_admin'],
                ':last_login' => $row['last_login'],
                ':created' => $row['created']
            ]
        );
        
        if($is_error) {
            $connection->exec('DROP TABLE users;' . $sql_users_rollback);
            return false;
        }
    }
    $sql_drop_backup = 'DROP TABLE users_backup';
    return $connection->exec($sql_drop_backup);
};