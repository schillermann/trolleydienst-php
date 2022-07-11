<?php return function (\PDO $connection): bool {

    if(!App\Tables\Users::create_table($connection)) {
        return false;
    }

    $sql_user_list = <<<'SQL'
        SELECT
            id_user, username, name, email, password,
            phone, mobile, congregation_name, language,
            note_user, note_admin, is_active, is_admin,
            last_login, updated, created
        FROM users
    SQL;

    foreach($connection->query($sql_user_list) as $row) {

        $stmt = $connection->prepare(
            <<<'SQL'
                INSERT INTO user (
                    id, username, first_name, last_name, email, password, phone,
                    mobile, congregation, language, note_user, note_admin,
                    active, administrative, logged_on, updated_on, created_on
                )
                VALUES (
                    :id, :username, :first_name, :last_name, :email, :password, :phone,
                    :mobile, :congregation, :language, :note_user, :note_admin,
                    :active, :administrative, :logged_on, :updated_on, :created_on
                )
            SQL
        );

        $name = explode(' ', $row['name']);
        $firstname = (array_key_exists(0, $name))? $name[0] : '';
        $lastname = (array_key_exists(1, $name))? $name[1] : '';

        $is_error = !$stmt->execute(
            [
                'id' => $row['id_user'],
                'username' => $row['username'],
                'first_name' => $firstname,
                'last_name' => $lastname,
                'email' => $row['email'],
                'password' => $row['password'],
                'phone' => $row['phone'],
                'mobile' => $row['mobile'],
                'congregation' => $row['congregation_name'],
                'language' => $row['language'],
                'note_user' => $row['note_user'],
                'note_admin' => $row['note_admin'],
                'active' => $row['is_active'],
                'administrative' => $row['is_admin'],
                'logged_on' => $row['last_login'],
                'updated_on' => $row['updated'],
                'created_on' => $row['created']
            ]
        );

        if($is_error) {
            $connection->exec('DROP TABLE user');
            return false;
        }
    }

    $connection->exec('DROP TABLE users');
    return true;
};