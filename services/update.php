<?php return function(\PDO $connection, $application_version): array {

    $dir = '../updates/';
    $directory_list = scandir($dir);
    $migration_files = array_slice($directory_list, 2);

    $success_migration_list = array();
    $sql_update_application_version =
        'UPDATE settings
        SET value = :application_version
        WHERE name = "application_version"';

    foreach ($migration_files as $migration_file)
    {
        $migration_version = str_replace('.php', '', $migration_file);

        if(version_compare($application_version, $migration_version) >= 0)
            continue;

        $migration_action = include $dir . $migration_file;
        if($migration_action($connection)) {
            $stmt = $connection->prepare ($sql_update_application_version);
            $stmt->execute(array(':application_version' => $migration_version));

            $success_migration_list[] = $migration_version;
        }
        else
        {
            throw new RuntimeException(
                'Die Migration ' . $migration_version . ' ist fehlgeschlagen!'
            );
        }
    }
    
     return $success_migration_list;
};