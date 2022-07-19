<?php
require __DIR__ . '/../vendor/autoload.php';
include '../config.php';
$database_pdo = App\Tables\Database::get_connection();
$placeholder = array();

if(isset($_POST['password_reset'])) {

    if(DEMO) {
        $placeholder['message']['error'] = __('Passwords cannot be changed in the demo version!');
    } else {
        $username = require('../filters/post_username.php');
        $email = require('../filters/post_email.php');

        $id_user = App\Tables\Publisher::select_id_user($database_pdo, $email, $username);

        if($id_user == 0) {
            $placeholder['message']['error'] = __('Name and/or email does not exist!');
        }
        else {
            $generate_password = require('../helpers/generate_password.php');
            $new_password = $generate_password();

            if(App\Tables\Publisher::update_password($database_pdo, $id_user, $new_password)) {

                $get_template_email_password_forgot = include '../services/get_email_template.php';
                $email_template = $get_template_email_password_forgot($database_pdo, App\Tables\EmailTemplates::PASSWORD_FORGOT);

                $replace_with = array(
                    'NAME' => App\Tables\Publisher::select_name($database_pdo, $id_user),
                    'PASSWORD' => $new_password,
                    'WEBSITE_LINK' => 'http://' . $_SERVER['SERVER_NAME']
                );

                $email_template_message = strtr($email_template['message'], $replace_with);

                $send_email = require('../modules/send_email.php');

                if($send_email($email, $email_template['subject'], $email_template_message)) {
                    $placeholder['message']['success'] = __('Your new password was sent to <b>%s</b> successfully.', [ $email ]);
                } else {
                    $placeholder['message']['error'] =
                        __('The new password could not be sent!<br><br>Please check that the server is correctly configured to send mail from the %s email address.', [ EMAIL_ADDRESS_FROM ]);
                }
            } else {
                $placeholder['message']['error'] = __('Your password could not be changed!');
            }
        }
    }
}

$render_page = require('../includes/render_page.php');
echo $render_page($placeholder);