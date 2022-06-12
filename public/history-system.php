<?php
$placeholder = require '../includes/init_page.php';
$placeholder['system_error_list'] = App\Tables\History::select_all($database_pdo, array(App\Tables\History::SYSTEM_ERROR));

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);