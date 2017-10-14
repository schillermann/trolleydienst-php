<?php
$placeholder = require 'includes/init_page.php';
$placeholder['shift_type_list'] = Tables\ShiftTypes::select_all($database_pdo);

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);