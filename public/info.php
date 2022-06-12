<?php
$placeholder = require '../includes/init_page.php';
$placeholder['file_list'] = App\Tables\Infos::select_all($database_pdo);

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);