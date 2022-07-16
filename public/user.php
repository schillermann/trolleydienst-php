<?php
$placeholder = require '../includes/init_page.php';

if ( isset($_POST["user_search"]) ) {
	$user_list = App\Tables\Users::select_user_search_name($database_pdo, $_POST["user_search"]);
} else {
	$user_list = App\Tables\Users::select_all($database_pdo);
}

$placeholder['user_list'] = $user_list;

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);