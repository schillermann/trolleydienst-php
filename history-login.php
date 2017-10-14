<?php
$placeholder = require 'includes/init_page.php';
$placeholder['login_error_list'] = Tables\History::select_all($database_pdo, array(Tables\History::LOGIN_ERROR));

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);