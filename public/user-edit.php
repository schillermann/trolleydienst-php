<?php
if(!isset($_GET['id_user'])) {
    header('location: /user.php');
    return;
}

$placeholder = require '../includes/init_page.php';
$id_user = (int)$_GET['id_user'];

if (isset($_POST['save'])) {
    if(DEMO) {
        $placeholder['message']['error'] = __('User details cannot be changed in the demo version!');
    } else {
        $user = new App\Models\User(
            $id_user,
            include '../filters/post_username.php',
            include '../filters/post_name.php',
            include '../filters/post_email.php',
            '',
            include '../filters/post_is_admin.php',
            include '../filters/post_is_active.php',
            include '../filters/post_phone.php',
            include '../filters/post_mobile.php',
            include '../filters/post_congregation_name.php',
            include '../filters/post_language.php',
            include '../filters/post_note_admin.php'
        );

        if(App\Tables\Users::update_user($database_pdo, $user)) {
            header('location: /user.php');
            return;
        } else {
            $placeholder['message']['error'] = __('The publisher details could not be changed!');
        }
    }
} elseif (isset($_POST['delete'])) {
    
    if(DEMO) {
         $placeholder['message']['error'] = __('Users cannot be deleted in the demo version!');
     } else {
        if(App\Tables\Users::delete($database_pdo, $id_user)) {
            header('location: /user.php');
            return;
        }
     }
} elseif(isset($_POST['password_save']) && !empty($_POST['password'])) {
    if(DEMO) {
        $placeholder['message']['error'] = __('Passwords cannot be changed in the demo version!');
    } else {
        if($_POST['password'] == $_POST['password_repeat'])
            if(App\Tables\Users::update_password($database_pdo, $id_user, $_POST['password']))
                $placeholder['message']['success'] = __('Your password has been changed successfully.');
            else
                $placeholder['message']['error'] = __('Your password could not be changed!');
        else
            $placeholder['message']['error'] = __('Passwords do not match!');
    }
} elseif(isset($_POST['resend_welcome_email'])) {

    $placeholder['message']['success'] = '';

    $get_template_email_user_add = include '../services/get_email_template.php';
    $email_template = $get_template_email_user_add($database_pdo, App\Tables\EmailTemplates::USER_ADD);

    $replace_with = array(
        'NAME' => $_POST['first_name'] . ' ' . $_POST['last_name'],
        'USERNAME' => $_POST['username'],
        'PASSWORD' => __('Hidden'),
        'EMAIL' => $_POST['email'],
        'WEBSITE_LINK' => 'https://' . $_SERVER['SERVER_NAME'] . '/',
        'SIGNATURE' => App\Tables\EmailTemplates::select($database_pdo, App\Tables\EmailTemplates::SIGNATURE)

    );
    $email_template_message = strtr($email_template['message'], $replace_with);

    $send_mail_plain = include '../modules/send_mail_plain.php';

    if($send_mail_plain($_POST['email'], $email_template['subject'], $email_template_message))
        $placeholder['message']['success'] .= __('The email has been sent to:') . ' ' . $_POST['email'];
}

$placeholder['user'] = App\Tables\Users::select_user($database_pdo, $id_user);

$user_updated = new \DateTime($placeholder['user']['updated_on']);
$user_created = new \DateTime($placeholder['user']['created_on']);
$placeholder['user']['updated_on'] = $user_updated->format(__('d/m/Y') . ' H:i');
$placeholder['user']['created_on'] = $user_created->format(__('d/m/Y') . ' H:i');

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);