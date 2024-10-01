<?php

namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class AddPublisherPage implements PageInterface
{
    public function __construct(private Config $config) {}

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $placeholder = require '../includes/init_page.php';
        $render_page = include '../includes/render_page.php';

        if (isset($_POST['save'])) {

            if ($this->config->demo()) {
                $placeholder['message']['error'] = __('Publishers cannot be created in the demo version!');
            } else {
                $username = include '../filters/post_username.php';

                if (Tables\Publisher::exists_username($database_pdo, $username)) {
                    $placeholder['message']['error'] = __('This username is already in use!');
                } else {
                    $get_password = require '../modules/random_string.php';
                    $password = $get_password(8);
                    $email = include '../filters/post_email.php';
                    $firstName = include '../filters/post_first_name.php';
                    $lastName = include '../filters/post_last_name.php';

                    $user = new Models\User(
                        0,
                        $username,
                        $firstName,
                        $lastName,
                        $email,
                        $password,
                        include '../filters/post_administrative.php',
                        true,
                        include '../filters/post_phone.php',
                        include '../filters/post_mobile.php',
                        include '../filters/post_congregation_name.php',
                        include '../filters/post_language.php',
                        include '../filters/post_admin_note.php'
                    );

                    if (!Tables\Publisher::insert($database_pdo, $user))
                        $placeholder['message']['error'] = __('The publisher could not be created!');
                    else {
                        $placeholder['message']['success'] = __('The publisher was created successfully.');

                        $get_template_email_user_add = include '../services/get_email_template.php';
                        $email_template = $get_template_email_user_add($database_pdo, Tables\EmailTemplates::USER_ADD);

                        $replace_with = array(
                            'NAME' => $firstName . ' ' . $lastName,
                            'USERNAME' => $username,
                            'EMAIL' => $email,
                            'PASSWORD' => $password,
                            'WEBSITE_LINK' => 'http://' . $_SERVER['SERVER_NAME'] . '?username=' . urlencode($username),
                            'SIGNATURE' => Tables\EmailTemplates::select($database_pdo, Tables\EmailTemplates::SIGNATURE)

                        );
                        $email_template_message = strtr($email_template['message'], $replace_with);

                        $send_email = require('../modules/send_email.php');

                        if ($send_email($email, $email_template['subject'], $email_template_message))
                            $placeholder['message']['success'] .= __('<br>An email with access data was sent to %s successfully.', [$email]);
                    }
                }
            }
        }

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $render_page($placeholder, 'user-add.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
