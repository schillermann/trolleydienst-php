<?php
$placeholder = require '../includes/init_page.php';

$user_list = App\Tables\Users::select_user_seach_name($database_pdo, $_POST["user_search"]);
$placeholder['user_list'] = $user_list;

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);