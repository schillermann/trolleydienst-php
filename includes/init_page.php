<?php
session_start();
if(empty($_SESSION)) {
    header('location: /');
    return;
}

require('../config.php');
require('../includes/language.php');
require __DIR__ . '/../vendor/autoload.php';

if(MAINTENANCE == true) {
    $_SESSION = array();
    header('location: /');
    return;
}

$database_pdo = App\Tables\Database::get_connection();
$placeholder = array();
$placeholder['shift_types'] = App\Shift\ShiftTypeTable::select_all($database_pdo);
return $placeholder;
