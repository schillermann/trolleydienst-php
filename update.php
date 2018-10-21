<?php
spl_autoload_register();
    
if(!Tables\Database::exists_database()) {
    header('location: install.php');
    return;
}

include 'config.php';
$database_pdo = Tables\Database::get_connection();
$placeholder = array();

if($_POST)
{
    $update = include 'services/update.php';
    
    try {
        $success_migrations = $update($database_pdo);

        if($success_migrations)
            $placeholder['message']['success']  =
                'Folgende Datenbank Migrationen wurden durchgeführt: ' . implode(', ', $success_migrations);
        else
            $placeholder['message']['success'] = 'Die Datenbank ist auf dem neusten Stand.';
    } catch (Exception $exc) {
        $placeholder['message']['error'] = $exc->getMessage();
    }
}
$is_uptodate = include 'services/is_uptodate.php';
$placeholder['is_up_to_date'] = $is_uptodate($database_pdo);

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);