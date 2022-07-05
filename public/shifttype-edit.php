<?php
$baseUrl = include '../includes/get_base_uri.php';

if(!isset($_GET['id_shift_type'])) {
    header('location: ' . $baseUrl . '/shifttype.php');
    return;
}
$placeholder = require '../includes/init_page.php';
$id_shift_type = (int)$_GET['id_shift_type'];

if (isset($_POST['save'])) {
    $name = include '../filters/post_name.php';
	$shift_type_info = include '../filters/post_shift_type_info.php';
    $user_per_shift_max = (int)$_POST['user_per_shift_max'];

    if(App\Tables\ShiftTypes::update($database_pdo, $id_shift_type, $name, $shift_type_info, $user_per_shift_max))
        $placeholder['message']['success'] = __('The changes have been saved.');
    else
        $placeholder['message']['error'] = __('The changes could not be saved!');
} elseif (isset($_POST['delete'])) {
    if(App\Tables\ShiftTypes::delete($database_pdo, $id_shift_type)) {
        header('location: ' . $baseUrl . '/shifttype.php');
        return;
    }
}

$placeholder['shift_type'] = App\Tables\ShiftTypes::select($database_pdo, $id_shift_type);

$updated = new \DateTime($placeholder['shift_type']['updated']);
$created = new \DateTime($placeholder['shift_type']['created']);
$placeholder['shift_type']['updated'] = $updated->format(__('d/m/Y') . ' H:i');
$placeholder['shift_type']['created'] = $created->format(__('d/m/Y') . ' H:i');

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);