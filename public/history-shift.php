<?php
$placeholder = require '../includes/init_page.php';

$get_history_shift = include '../services/get_history_shift.php';
$shift_history_list = $get_history_shift($database_pdo);

$placeholder['shift_error_list'] = array();
$placeholder['shift_success_list'] = array();

if(isset($shift_history_list['error']))
    $placeholder['shift_error_list'] = $shift_history_list['error'];
if(isset($shift_history_list['success']))
    $placeholder['shift_success_list'] = $shift_history_list['success'];

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);