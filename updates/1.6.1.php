<?php return function (\PDO $connection): bool {

    $sql_create_backup = 'ALTER TABLE shift_user_maps RENAME TO shift_user_maps_backup';
    $sql_rollback = 'ALTER TABLE shift_user_maps_backup RENAME TO shift_user_maps';

    if($connection->exec($sql_create_backup) === false)
        return false;

    if(!App\Tables\ShiftUserMaps::create_table($connection)) {
        $connection->exec($sql_rollback);
        return false;
    }

    $sql_user_list = 'SELECT id_shift, id_user, position, created FROM shift_user_maps_backup';
    $sql_insert_user =
        'INSERT INTO shift_user_maps (
            id_shift, id_user, position, created
        )
        VALUES (
            :id_shift, :id_user, :position, :created
        )';
    foreach($connection->query($sql_user_list) as $row) {

        $stmt = $connection->prepare($sql_insert_user);
        $is_error = !$stmt->execute(
            array(
                'id_shift' => $row['id_shift'],
                'id_user' => $row['id_user'],
                ':position' => $row['position'],
                ':created' => $row['created']
            )
        );

        if($is_error) {
            $connection->exec('DROP TABLE shift_user_maps;' . $sql_rollback);
            return false;
        }
    }

    $sql_drop_backup = 'DROP TABLE shift_user_maps_backup';
    $isDropBackupRemoved = $connection->exec($sql_drop_backup);

    $sql_remove_email_template = 'DELETE FROM email_templates WHERE id_email_template = 8';
    $sql_insert_email_template =
        'INSERT INTO email_templates (id_email_template, subject, message, updated)
        VALUES (8, "Zugangsdaten", "Hallo NAME,

mit den Zugangsdaten kannst du dich auf WEBSITE_LINK anmelden. 

== Zugangsdaten ==

Benutzername: USERNAME
Passwort: PASSWORD

==============

SIGNATURE", datetime("now", "localtime"))';

    $isEmailTemplateUpdated = $connection->exec($sql_remove_email_template) && $connection->exec($sql_insert_email_template);

    return $isDropBackupRemoved && $isEmailTemplateUpdated;
};