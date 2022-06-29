<?php
$placeholder = require '../includes/init_page.php';

$user_list = App\Tables\Users::select_all($database_pdo);
$placeholder['user_list'] = $user_list;

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);