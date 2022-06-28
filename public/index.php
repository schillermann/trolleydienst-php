<?php
session_start();
$baseUrl = include '../includes/get_base_uri.php';

if(isset($_GET['logout'])) {
    $_SESSION = array();
    header('location: ' . $baseUrl);
    return;
}

require __DIR__ . '/../vendor/autoload.php';

if(!App\Tables\Database::exists_database()) {
    header('location: ' . $baseUrl . '/install.php');
    return;
}

if(isset($_SESSION) && !empty($_SESSION)) {
	header('location: ' . $baseUrl . '/shift.php');
	return;
}

include '../config.php';

$placeholder = array();
$placeholder['email_or_username'] = include '../filters/get_username.php';

if(isset($_POST['email_or_username']) && isset($_POST['password'])) {

    $check_login = include '../includes/check_login.php';
    $placeholder['post_email_or_username']  = include '../filters/post_email_or_username.php';
    $database_pdo = App\Tables\Database::get_connection();

    $get_ban_time_in_minutes = include '../services/get_ban_time_in_minutes.php';
    $ban_time_in_minutes = $get_ban_time_in_minutes($database_pdo, BAN_TIME_IN_MINUTES);

    if($ban_time_in_minutes > 0) {
        $placeholder['message']['error'] = 'Du bist noch für ' . $ban_time_in_minutes . ' Minuten gesperrt!';
    } elseif($check_login($database_pdo, $placeholder['post_email_or_username'] , $_POST['password'])) {
        header('location: ' . $baseUrl . '/shift.php');
        return;
    }
    else {
        $set_ban_time = include '../services/set_ban_time.php';

        if($set_ban_time($database_pdo, LOGIN_FAIL_MAX))
            $placeholder['message']['error'] = __('Du bist für ') . BAN_TIME_IN_MINUTES . __(' Minuten gesperrt!');
        else
            $placeholder['message']['error'] = __('Anmeldung ist fehlgeschlagen!');

        $user_ip_address = include '../modules/get_ip_address.php';

        App\Tables\History::insert(
            $database_pdo,
            $placeholder['post_email_or_username'] ,
            App\Tables\History::LOGIN_ERROR,
            __('Anmeldung mit der IP ') . $user_ip_address . __(' ist fehlgeschlagen!')
        );
    }
}

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);
?>