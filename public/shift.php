<?php
$placeholder = require '../includes/init_page.php';

if(!isset($_GET['id_shift_type'])) {
    $id_shift_type = App\Tables\ShiftTypes::select_first_id_shift_type($database_pdo);
    if($id_shift_type)
        header('location: /shift.php?id_shift_type=' . $id_shift_type);
    else
        header('location: /info.php');
    return;
}
if (isset($_POST['promote_id_user'])) {

    $promote_user = include '../services/promote_user.php';

    if($promote_user($database_pdo, (int)$_POST['id_shift'], (int)$_POST['position'], (int)$_POST['promote_id_user']))
        $placeholder['message']['success'] = __('Your application was successful.');
    else
        $placeholder['message']['error'] = __('Your application was unsuccessful.');

} elseif (isset($_POST['cancel_id_user'])) {

    $cancel_application = include '../services/cancel_application.php';
    if($cancel_application($database_pdo, (int)$_POST['id_shift'], (int)$_POST['position'], (int)$_POST['cancel_id_user']))
        $placeholder['message']['success'] = __('Your application was withdrawn.');
    else
        $placeholder['message']['error'] = __('Your application could not be withdrawn.');

}

$id_shift_type = (int)$_GET['id_shift_type'];
$placeholder['shift_type'] = App\Tables\ShiftTypes::select($database_pdo, $id_shift_type);

if(!empty($placeholder['shift_type']['info'])) {
    $parse_text_to_html = include '../templates/helpers/parse_text_to_html.php';
    $placeholder['shift_type']['info'] = $parse_text_to_html($placeholder['shift_type']['info']);
}

$user_list = App\Tables\Users::select_all_without_user($database_pdo, $_SESSION['id_user']);
$get_user_promote_list = include '../helpers/get_user_promote_list.php';
$placeholder['user_promote_list'] = $get_user_promote_list($user_list);
$placeholder['id_shift_type'] = $id_shift_type;

$get_shifts_with_users = include '../services/get_shifts_with_users.php';
$placeholder['shift_day'] = $get_shifts_with_users($database_pdo, $id_shift_type);

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);