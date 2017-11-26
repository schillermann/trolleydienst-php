<?php
$placeholder = require 'includes/init_page.php';

if(!isset($_GET['id_shift_type'])) {
    $id_shift_type = Tables\ShiftTypes::select_first_id_shift_type($database_pdo);
    if($id_shift_type)
        header('location: shift.php?id_shift_type=' . $id_shift_type);
    else
        header('location: info.php');
    return;
}

$id_shift_type = (int)$_GET['id_shift_type'];
$action = include 'helpers/get_action.php';

if($action == 'promote') {

    $promote_user = include 'services/promote_user.php';

    if($promote_user($database_pdo, (int)$_GET['id_shift'], (int)$_GET['position'], (int)$_POST['id_user']))
        $placeholder['message']['success'] = 'Die Bewerbung wurde angenommen.';
    else
        $placeholder['message']['error'] = 'Die Bewerbung konnte nicht angenommen werden!';

} elseif ($action == 'cancel') {

    $cancel_application = include 'services/cancel_application.php';
    if($cancel_application($database_pdo, (int)$_GET['id_shift'], (int)$_GET['position'], (int)$_POST['id_user']))
        $placeholder['message']['success'] = 'Die Bewerbung wurde zurück gezogen.';
    else
        $placeholder['message']['error'] = 'Die Bewerbung konnte nicht zurück gezogen werden!';
} elseif ($action == 'userinfo') {
    header('location: user-details.php?id_shift_type=' . $id_shift_type . '&id_user=' . $_POST['id_user']);
    return;
}


$placeholder['shift_type'] = Tables\ShiftTypes::select($database_pdo, $id_shift_type);

if(!empty($placeholder['shift_type']['info'])) {
    $parse_text_to_html = include 'templates/helpers/parse_text_to_html.php';
    $placeholder['shift_type']['info'] = $parse_text_to_html($placeholder['shift_type']['info']);
}

$get_user_promote_list = include 'services/get_user_promote_list.php';
$placeholder['user_promote_list'] = $get_user_promote_list($database_pdo);

$placeholder['id_shift_type'] = $id_shift_type;

$get_shifts_with_users = include 'services/get_shifts_with_users.php';
$placeholder['shift_day'] = $get_shifts_with_users($database_pdo, $id_shift_type);

$placeholder['form_uri'] = 'id_shift_type=%d&id_shift=%d&position=%d#id_shift_%2$d';

$render_page = include 'includes/render_page.php';

if($_SESSION['is_admin'])
    if(APPLICANT_ACTIVATION)
        echo $render_page($placeholder, 'shift-admin-activation.php');
    else
        echo $render_page($placeholder, 'shift-admin.php');
else
    if(APPLICANT_ACTIVATION)
        echo $render_page($placeholder, 'shift-activation.php');
    else
        echo $render_page($placeholder);