<?php
$placeholder = require '../includes/init_page.php';
$placeholder['email'] = array();

if(isset($_POST['send']) && !empty($_POST['email_subject']) && !empty($_POST['email_message'])) {

    $placeholder['email']['subject'] = $_POST['email_subject'];
    $placeholder['email']['message'] = $_POST['email_message'];
    
    if(DEMO) {
        $placeholder['message']['error'] = __('In der Demo Version darf keine E-Mail gesendet werden!');
    } else {

        $placeholder['user_list'] = App\Tables\Users::select_all_email($database_pdo);

        if(empty($placeholder['user_list']))
            $placeholder['message']['error'] = __('Es wurden keine E-Mail Adresse für den Versand gefunden!');
        else {
            $placeholder['message']['success'] = __('E-Mail wurde versendet an:');

            foreach ($placeholder['user_list'] as $user) {
                $replace_with = array(
                    'NAME' => $user['name'],
                    'WEBSITE_LINK' => 'http://' . $_SERVER['SERVER_NAME'] . '?username=' . urlencode($user['username'])
                );
                $email_message = strtr($placeholder['email']['message'], $replace_with);

                $send_mail_plain = include '../modules/send_mail_plain.php';
                if($send_mail_plain($user['email'], $placeholder['email']['subject'], $email_message))
                    $placeholder['user_list'][] = $user;
            }
        }  
    }
} else {
    $get_email_template = include '../services/get_email_template.php';
    $placeholder['email'] = $get_email_template($database_pdo);
}

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);