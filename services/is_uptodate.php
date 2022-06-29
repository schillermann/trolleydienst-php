<?php return function(\PDO $connection): bool {
    $application_version = include '../includes/get_version.php';
    
     try {
        $query = $connection->query('SELECT value FROM settings WHERE name = "application_version"');

         if(version_compare($application_version, $query->fetchColumn()) == 0)
             return true;
         else
             return false;
    } catch (Exception $exc) {
        return false;
    }
};