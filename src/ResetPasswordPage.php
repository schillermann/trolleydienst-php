<?php

namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ResetPasswordPage implements PageInterface
{
    function __construct(private Config $config)
    {
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        include '../config.php';
        include '../includes/language.php';
        $database_pdo = Tables\Database::get_connection();
        $placeholder = array();

        if (isset($_POST['password_reset'])) {

            if ($this->config->demo()) {
                $placeholder['message']['error'] = __('Passwords cannot be changed in the demo version!');
            } else {
                $username = require('../filters/post_username.php');
                $email = require('../filters/post_email.php');

                $id_user = Tables\Publisher::select_id_user($database_pdo, $email, $username);

                if ($id_user == 0) {
                    $placeholder['message']['error'] = __('Name and/or email does not exist!');
                } else {
                    $generate_password = require('../helpers/generate_password.php');
                    $new_password = $generate_password();

                    if (Tables\Publisher::update_password($database_pdo, $id_user, $new_password)) {

                        $get_template_email_password_forgot = include '../services/get_email_template.php';
                        $email_template = $get_template_email_password_forgot($database_pdo, Tables\EmailTemplates::PASSWORD_FORGOT);

                        $replace_with = array(
                            'NAME' => Tables\Publisher::select_name($database_pdo, $id_user),
                            'PASSWORD' => $new_password,
                            'WEBSITE_LINK' => 'http://' . $_SERVER['SERVER_NAME']
                        );

                        $email_template_message = strtr($email_template['message'], $replace_with);

                        $send_email = require('../modules/send_email.php');

                        if ($send_email($email, $email_template['subject'], $email_template_message) == '') {
                            $placeholder['message']['success'] = __('Your new password was sent to <b>%s</b> successfully.', [$email]);
                        } else {
                            $placeholder['message']['error'] =
                                __('The new password could not be sent!<br><br>Please check that the server is correctly configured to send mail from the %s email address.', [EMAIL_ADDRESS_FROM]);
                        }
                    } else {
                        $placeholder['message']['error'] = __('Your password could not be changed!');
                    }
                }
            }
        }

        $render_page = require('../includes/render_page.php');

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::METADATA_BODY,
                $render_page($placeholder, 'password-forgot.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
