<?php
require '../includes/language.php';

define('LANGUAGE', include('../helpers/get_language.php'));
define('APPLICATION_NAME', __('Public Witnessing'));
define('CONGREGATION_NAME', __('Installation'));
define('REQUIRE_INPUT_FIELDS', 10);

require __DIR__ . '/../vendor/autoload.php';

if(App\Tables\Database::exists_database()) {
    header('location: /');
    return;
}

$placeholder = [];

if(isset($_POST['install'])) {
    $filter_post_input = include '../modules/filter_post_input.php';
    $input_list = $filter_post_input();

    if(empty($_POST['password']) || empty($_POST['password_repeat']) || $_POST['password'] != $_POST['password_repeat']) {
        $placeholder['message']['error'] = __('Passwords do not match!');
    } else if(count($input_list) === REQUIRE_INPUT_FIELDS) {

        $user = new App\Models\User(
            1,
            $input_list['username'],
            $input_list['first_name'],
            $input_list['last_name'],
            $input_list['email'],
            $_POST['password'],
            true
        );

        $pdo = App\Tables\Database::get_connection();
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
            'TIMEZONE' => 'Europe/Berlin'
        );

        if(
            App\Tables\Database::create_tables($pdo) &&
            App\Tables\Users::insert($pdo, $user) &&
            $pdo->exec(include '../install/sql_import.php') !== false &&
            $write_config_file($config)
        ) {
            header('location: /?email=' . urlencode($input_list['email']));
            return;
        }

        $placeholder['message']['error'] = __('An error occurred during the installation!');
    } else {
        $placeholder['message']['error'] = __('All required fields must be completed!');
    }
}

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);