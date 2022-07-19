<?php
session_start();

if(isset($_GET['logout'])) {
    $_SESSION = array();
    header('location: /');
    return;
}

require __DIR__ . '/../vendor/autoload.php';

if(!App\Tables\Database::exists_database()) {
    header('location: /install.php');
    return;
}

if(isset($_SESSION) && !empty($_SESSION)) {
	header('location: /shift.php');
	return;
}

include '../config.php';
include '../includes/language.php';

$placeholder = array();
$placeholder['email_or_username'] = require('../filters/get_username.php');

if(isset($_POST['email_or_username']) && isset($_POST['password'])) {

    $check_login = require('../includes/check_login.php');
    $placeholder['post_email_or_username']  = require('../filters/post_email_or_username.php');
    $database_pdo = App\Tables\Database::get_connection();

    $get_ban_time_in_minutes = require('../services/get_ban_time_in_minutes.php');
    $ban_time_in_minutes = $get_ban_time_in_minutes($database_pdo, BAN_TIME_IN_MINUTES);

    if($ban_time_in_minutes > 0) {
        $placeholder['message']['error'] = 'Du bist noch für ' . $ban_time_in_minutes . ' Minuten gesperrt!';
    } elseif($check_login($database_pdo, $placeholder['post_email_or_username'] , $_POST['password'])) {
        header('location: /shift.php');
        return;
    }
    else {
        $set_ban_time = require('../services/set_ban_time.php');

        if($set_ban_time($database_pdo, LOGIN_FAIL_MAX))
            $placeholder['message']['error'] = __('You have been blocked for %d minutes!', [ BAN_TIME_IN_MINUTES ]);
        else
            $placeholder['message']['error'] = __('Login failed!');

        $user_ip_address = require('../modules/get_ip_address.php');

        App\Tables\History::insert(
            $database_pdo,
            $placeholder['post_email_or_username'] ,
            App\Tables\History::LOGIN_ERROR,
            __('Login with the IP %s failed!', [ $user_ip_address ])
        );
    }
}

$render_page = require('../includes/render_page.php');
echo $render_page($placeholder);
?>