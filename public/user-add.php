<?php
$placeholder = require '../includes/init_page.php';
$render_page = include '../includes/render_page.php';

$page_file = '';

if(isset($_POST['save'])) {

    if(DEMO) {
        $placeholder['message']['error'] = __('Publishers cannot be created i nthe demo version!');
    } else {
        $username = include '../filters/post_username.php';

        if(App\Tables\Users::exists_username($database_pdo, $username)) {
            $placeholder['message']['error'] = __('This username is already in use!');
        } else {
            $get_password = require '../modules/random_string.php';
            $password = $get_password(8);
            $email = include '../filters/post_email.php';
            $name = include '../filters/post_name.php';

            $user = new App\Models\User(
                0,
                $username,
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
                $placeholder['message']['error'] = __('The publisher could not be created!');
            else {
                $placeholder['message']['success'] = __('The publisher was created successfully.');

                $get_template_email_user_add = include '../services/get_email_template.php';
                $email_template = $get_template_email_user_add($database_pdo, App\Tables\EmailTemplates::USER_ADD);

                $replace_with = array(
                    'NAME' => $name,
                    'USERNAME' => $username,
                    'EMAIL' => $email,
                    'PASSWORD' => $password,
                    'WEBSITE_LINK' => 'http://' . $_SERVER['SERVER_NAME'] . '?username=' . urlencode($username),
                    'SIGNATURE' => App\Tables\EmailTemplates::select($database_pdo, App\Tables\EmailTemplates::SIGNATURE)

                );
                $email_template_message = strtr($email_template['message'], $replace_with);

                $send_mail_plain = include '../modules/send_mail_plain.php';

                if($send_mail_plain($email, $email_template['subject'], $email_template_message))
                    $placeholder['message']['success'] .= __('<br>An email with access data was sent to %s successfully.', [ $email ]);
            }
        }  
    }
}

echo $render_page($placeholder, $page_file);