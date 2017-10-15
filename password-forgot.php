<?php
spl_autoload_register();
include 'config.php';
$database_pdo = Tables\Database::get_connection();
$placeholder = array();

if(isset($_POST['password_reset'])) {

    $name = include 'filters/post_name.php';
    $send_to_email = include 'filters/post_email.php';

    $id_user = Tables\Users::select_id_user($database_pdo, $name, $send_to_email);

    if($id_user == 0) {
        $placeholder['message']['error'] = 'Name oder E-Mail existiert nicht!';
    }
    else {
        $generate_password = include 'helpers/generate_password.php';
        $new_password = $generate_password();

        if(Tables\Users::update_password($database_pdo, $id_user, $new_password)) {

            $get_template_email_password_forgot = include 'services/get_email_template.php';
            $email_template = $get_template_email_password_forgot($database_pdo, Tables\EmailTemplates::PASSWORD_FORGOT);

            $replace_with = array(
                'NAME' => Tables\Users::select_name($database_pdo, $id_user),
                'PASSWORD' => $new_password
            );

            $email_template_message = strtr($email_template['message'], $replace_with);

            $send_mail_plain = include 'modules/send_mail_plain.php';

            if($send_mail_plain($send_to_email, $email_template['subject'], $email_template_message))
                $placeholder['message']['success'] = 'Dein neues Passwort wurde an <b>' . $send_to_email . '</b> versandt.';
        } else {
            $placeholder['message']['error'] = 'Dein Passwort konnte nicht geändert werden!';
        }
    }
}

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);