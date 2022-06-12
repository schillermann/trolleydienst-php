<?php
$placeholder = require '../includes/init_page.php';

if(isset($_POST['save'])) {
    $name = include '../filters/post_name.php';
	$shift_type_info = include '../filters/post_shift_type_info.php';
    $user_per_shift_max = (int)$_POST['user_per_shift_max'];

    if(App\Tables\ShiftTypes::insert($database_pdo, $name, $shift_type_info, $user_per_shift_max))
        $placeholder['message']['success'] = 'Neuer Schichttyp wurde hinzugefügt.';
    else
        $placeholder['message']['error'] = 'Der neue Schichttyp konnte nicht hinzugefügt werden!';
}

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);