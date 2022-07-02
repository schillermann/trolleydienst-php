<?php
require __DIR__ . '/../vendor/autoload.php';
$baseUrl = include '../includes/get_base_uri.php';
include '../includes/language.php';
 
if(!App\Tables\Database::exists_database()) {
    header('location: ' . $baseUrl . '/install.php');
    return;
}

include '../config.php';
$database_pdo = App\Tables\Database::get_connection();
$placeholder = [];

if($_POST)
{
    $get_database_version = include '../services/get_database_version.php';
    $update = include '../services/update.php';
    
    try {
        $database_version = $get_database_version($database_pdo);
        $success_migrations = $update($database_pdo, $database_version);

        if($success_migrations)
            $placeholder['message']['success']  =
                __('The following database migrations were carried out successfully: ') . implode(', ', $success_migrations);
        else
            $placeholder['message']['success'] = __('The database is up to date.');
    } catch (Exception $exc) {
        $placeholder['message']['error'] = $exc->getMessage();
    }
}
$is_uptodate = include '../services/is_uptodate.php';
$placeholder['is_up_to_date'] = $is_uptodate($database_pdo);

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);