<?php
session_start();

if(isset($_GET['logout'])) {
    $_SESSION = array();
    header('location: ./');
    return;
}

spl_autoload_register();

if(!Tables\Database::exists_database()) {
    header('location: install.php');
    return;
}

if(isset($_SESSION) && !empty($_SESSION)) {
	header('location: shift.php');
	return;
}

include 'config.php';
$placeholder = array();
$placeholder['username'] = include 'filters/get_username.php';

if(isset($_POST['username']) && isset($_POST['password'])) {

    $check_login = include 'includes/check_login.php';
    $placeholder['username']  = include 'filters/post_username.php';
    $database_pdo = Tables\Database::get_connection();

    $get_ban_time_in_minutes = include 'services/get_ban_time_in_minutes.php';
    $ban_time_in_minutes = $get_ban_time_in_minutes($database_pdo, BAN_TIME_IN_MINUTES);

    if($ban_time_in_minutes > 0) {
        $placeholder['message']['error'] = 'Du bist noch für ' . $ban_time_in_minutes . ' Minuten gesperrt!';
    } elseif($check_login($database_pdo, $placeholder['username'] , $_POST['password'])) {
        header('location: shift.php');
        return;
    }
    else {
        $set_ban_time = include 'services/set_ban_time.php';

        if($set_ban_time($database_pdo, LOGIN_FAIL_MAX))
            $placeholder['message']['error'] = 'Du bist für ' . BAN_TIME_IN_MINUTES . ' Minuten gesperrt!';
        else
            $placeholder['message']['error'] = 'Anmeldung ist fehlgeschlagen!';

        $user_ip_address = include 'modules/get_ip_address.php';

        Tables\History::insert(
            $database_pdo,
            $placeholder['username'] ,
            Tables\History::LOGIN_ERROR,
            'Anmeldung mit der IP ' . $user_ip_address . ' ist fehlgeschlagen!'
        );
    }
}

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);
?>