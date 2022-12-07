<?php
namespace App;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class InstallPage implements PageInterface
{
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        require '../includes/language.php';

        define('LANGUAGE', require('../helpers/get_language.php'));
        define('APPLICATION_NAME', __('Public Witnessing'));
        define('CONGREGATION_NAME', __('Installation'));
        define('REQUIRE_INPUT_FIELDS', 9);

        require __DIR__ . '/../vendor/autoload.php';

        if(Tables\Database::exists_database()) {
            header('location: /');
            exit;
        }

        $placeholder = [];

        if(isset($_POST['install'])) {
            $filter_post_input = include '../modules/filter_post_input.php';
            $input_list = $filter_post_input();

            if(empty($_POST['password']) || empty($_POST['password_repeat']) || $_POST['password'] != $_POST['password_repeat']) {
                $placeholder['message']['error'] = __('Passwords do not match!');
            } else if(count($input_list) >= REQUIRE_INPUT_FIELDS) {

                $user = new Models\User(
                    1,
                    $input_list['username'],
                    $input_list['first_name'],
                    $input_list['last_name'],
                    $input_list['email'],
                    $_POST['password'],
                    true
                );

                $pdo = Tables\Database::get_connection();
                $write_config_file = include '../modules/write_config_file.php';
                $config = array(
                    'EMAIL_ADDRESS_FROM' => $input_list['email_address_from'],
                    'EMAIL_ADDRESS_REPLY' => $input_list['email_address_reply'],
                    'CONGREGATION_NAME' => $input_list['congregation_name'],
                    'APPLICATION_NAME' => $input_list['application_name'],
                    'TEAM_NAME' => $input_list['team_name'],
                    'UPLOAD_SIZE_MAX_IN_MEGABYTE' => 5,
                    'BAN_TIME_IN_MINUTES' => 5,
                    'LOGIN_FAIL_MAX' => 5,
                    'DEMO' => false,
                    'LANGUAGE' => $input_list['language'],
                    'TIMEZONE' => $input_list['timezone'],
                    'EMAIL_DISPATCH' => $input_list['email_dispatch'],
                    'MAIL_SENDINBLUE_API_KEY' => $input_list['email_sendinblue_api_key'],
                    'SMTP_HOST' => $input_list['email_smtp_host'],
                    'SMTP_USERNAME' => $input_list['email_smtp_username'],
                    'SMTP_PASSWORD' => $_POST['email_smtp_password'],
                    'SMTP_PORT' => (int)$input_list['email_smtp_port'],
                    'SMTP_ENCRYPTION' => $input_list['email_smtp_encryption'],
                    'MAINTENANCE' => false

                );

                if(
                    Tables\Database::create_tables($pdo) &&
                    Tables\Publisher::insert($pdo, $user) &&
                    $pdo->exec(include '../install/sql_import.php') !== false &&
                    $write_config_file($config)
                ) {
                    header('location: /?email=' . urlencode($input_list['email']));
                    exit;
                }

                $placeholder['message']['error'] = __('An error occurred during the installation!');
            } else {
                $placeholder['message']['error'] = __('All required fields must be completed!');
            }
        }

        $render_page = include '../includes/render_page.php';

        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $render_page($placeholder, 'install.php')
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}