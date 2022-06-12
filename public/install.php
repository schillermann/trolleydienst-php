<?php
define('APPLICATION_NAME', 'Öffentliches Zeugnisgeben');
define('CONGREGATION_NAME', 'Installation');
define('REQUIRE_INPUT_FIELDS', 8);

$baseUrl = include '../includes/get_base_uri.php';

require __DIR__ . '/../vendor/autoload.php';

if(App\Tables\Database::exists_database()) {
    header('location: ' . $baseUrl);
    return;
}

$placeholder = array();

if(isset($_POST['install'])) {
    $filter_post_input = include '../modules/filter_post_input.php';
    $input_list = $filter_post_input();

    if(empty($_POST['password']) || empty($_POST['password_repeat']) || $_POST['password'] != $_POST['password_repeat']) {
        $placeholder['message']['error'] = 'Passwörter stimmen nicht überein!';
    } else if(count($input_list) === REQUIRE_INPUT_FIELDS) {

        $user = new App\Models\User(
            1,
            $input_list['username'],
            $input_list['name'],
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
            'DEMO' => false
        );

        if(
            App\Tables\Database::create_tables($pdo) &&
            App\Tables\Users::insert($pdo, $user) &&
            $pdo->exec(include '../install/sql_import.php') !== false &&
            $write_config_file($config)
        ) {
            header('location: ' . $baseUrl . '/?username=' . urlencode($input_list['username']));
            return;
        }

        $placeholder['message']['error'] = 'Bei der Installation ist ein Fehler aufgetreten!';
    } else {
        $placeholder['message']['error'] = 'Alle Pflichtfelder müssen ausgefüllt werden!';
    }
}

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);