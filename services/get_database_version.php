<?php return function(\PDO $connection): string {

    try {
        $query = $connection->query('SELECT value FROM settings WHERE name = "application_version"');
        $application_version = $query->fetchColumn();
        return $application_version;
    } catch (Exception $error) {
        $application_version = include '../includes/get_version.php';

        $sql_create_table_settings =
            'CREATE TABLE `settings` (
            `name` TEXT,
            `value` TEXT,
            PRIMARY KEY(`name`)
        )';

        $sql_insert_application_version =
            'INSERT INTO settings (name, value)
            VALUES ("application_version", :application_version)';

        $connection->query($sql_create_table_settings);

        $stmt = $connection->prepare($sql_insert_application_version);
        $stmt->execute(array(':application_version' => $application_version));

        return $application_version;
    }
};