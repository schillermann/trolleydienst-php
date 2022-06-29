<?php
$baseUrl = include '../includes/get_base_uri.php';

if(!isset($_GET['id_user'])) {
    header('location: ' . $baseUrl . '/shift.php');
    return;
}

$placeholder = require '../includes/init_page.php';
$id_user = (int)$_GET['id_user'];
$user = App\Tables\Users::select_user($database_pdo, $id_user);
$placeholder['user'] = $user;

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);