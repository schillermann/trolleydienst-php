<?php
$placeholder = require '../includes/init_page.php';
$render_page = include '../includes/render_page.php';

$page_file = '';

if(isset($_POST['save'])) {

    if(DEMO) {
        $placeholder['message']['error'] = 'In der Demo Version darf kein Teilnehmer angelegt werden!';
    } else {
        $email = include '../filters/post_email.php';

        if(App\Tables\Users::exists_email($database_pdo, $email)) {
            $placeholder['message']['error'] = 'Der Name ist bereits vergeben!';
        } else {
            $get_password = require '../modules/random_string.php';
            $password = $get_password(8);
            $email = include '../filters/post_email.php';
            $name = include '../filters/post_name.php';

            $user = new App\Models\User(
                0,
                $name,
                $email,
                $password,
                include '../filters/post_is_admin.php',
                true,
                include '../filters/post_phone.php',
                include '../filters/post_mobile.php',
                include '../filters/post_congregation_name.php',
                include '../filters/post_language.php',
                include '../filters/post_note_admin.php'
            );

            if (!App\Tables\Users::insert($database_pdo, $user))
                $placeholder['message']['error'] = 'Der Teilnehmer konnte nicht angelegt werden!';
            else {
                $placeholder['message']['success'] = 'Der Teilnehmer wurde angelegt.';

                $get_template_email_user_add = include '../services/get_email_template.php';
                $email_template = $get_template_email_user_add($database_pdo, App\Tables\EmailTemplates::USER_ADD);

                $replace_with = array(
                    'NAME' => $name,
                    'EMAIL' => $email,
                    'PASSWORD' => $password
                );
                $email_template_message = strtr($email_template['message'], $replace_with);

                $send_mail_plain = include '../modules/send_mail_plain.php';

                if($send_mail_plain($email, $email_template['subject'], $email_template_message))
                    $placeholder['message']['success'] .= '<br>Eine E-Mail mit den Zugangsdaten wurde an ' . $email . ' geschickt.';
            }
        }  
    }
}

echo $render_page($placeholder, $page_file);