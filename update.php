<?php
define('APPLICATION_NAME', 'Öffentliches Zeugnisgeben');
define('CONGREGATION_NAME', 'Update');
$placeholder = [];

if($_POST)
{
    spl_autoload_register();
    
    if(!Tables\Database::exists_database()) {
        header('location: install.php');
        return;
    }

    $database_pdo = Tables\Database::get_connection();
    $start_update = false;

    try {
        $query = $database_pdo->query('SELECT value FROM settings WHERE name = "application_version"');
        $application_version = $query->fetchColumn();    
    } catch (Exception $exc) {

        $application_version = include 'includes/get_version.php';

        $sql_create_table_settings =
            'CREATE TABLE `settings` (
            `name` TEXT,
            `value` TEXT,
            PRIMARY KEY(`name`)
        )';
        $sql_insert_application_version =
            'INSERT INTO settings
            (name)
            VALUES ("application_version")';

        $database_pdo->query($sql_create_table_settings);
        $database_pdo->query($sql_insert_application_version);
        $start_update = true;
    }

    $sql_update_application_version =
            'UPDATE settings
            SET value = :application_version
            WHERE name = "application_version"';

    $dir    = 'updates/';
    $directory_list = scandir($dir);
    $migration_files = array_slice($directory_list, 2);
    $success_migration_version_list = [];

    foreach ($migration_files as $migration_file)
    {
        $migration_version = str_replace('.php', '', $migration_file);

        if($start_update)
        {
            $migration_action = include $dir . $migration_file;
            if($migration_action()) {
                $stmt = $database_pdo->prepare ($sql_update_application_version);
                if(!$stmt->execute(array(':application_version' => $migration_version)))
                {
                    $placeholder['message']['error'] = 'Die Versionsnummer ' . $migration_version . ' konnte in der Datenbank nicht gesetzt werden!';
                    break;
                }
                $success_migration_version_list[] = $migration_version;
            }
            else
            {
                $placeholder['message']['error'] = 'Die Migration ' . $migration_version . ' ist fehlgeschlagen!';
                break;
            }
        }

        if($migration_version == $application_version)
                $start_update = true;
    }

    if($success_migration_version_list)
        $placeholder['message']['success']  = 'Folgende Datenbank Migrationen wurden durchgeführt: ' . implode(', ', $success_migration_version_list);
    else
        $placeholder['message']['success'] = 'Die Datenbank ist auf dem neusten Stand.';
    
    $placeholder['message']['success'] .= ' LÖSCHE BITTE AUS SICHERHEITSGRÜNDEN DIE DATEI update.php VOM SERVER!';
}

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);