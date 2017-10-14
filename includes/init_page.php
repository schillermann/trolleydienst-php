<?php
session_start();
if(empty($_SESSION)) {
    header('location: /');
    return;
}

include 'config.php';
spl_autoload_register();
$database_pdo = Tables\Database::get_connection();
$placeholder = array();
$placeholder['shift_types'] = Tables\ShiftTypes::select_all($database_pdo);
return $placeholder;
