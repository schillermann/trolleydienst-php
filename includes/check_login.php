<?php
return function (\PDO $database_pdo, string $email_or_username, string $password): bool {

    $user = App\Tables\Publisher::select_logindata($database_pdo, $email_or_username, $password);

    if(empty($user))
        return false;

	$user_ip_address = require('../modules/get_ip_address.php');
    App\Tables\LoginFails::delete($database_pdo, $user_ip_address);

    $_SESSION['id_user'] = (int)$user['id'];
    $_SESSION['name'] = $user['first_name'] . ' ' . $user['last_name'];
    $_SESSION['is_admin'] = (bool)$user['administrative'];

    App\Tables\Publisher::update_login_time($database_pdo, $_SESSION['id_user']);

    return true;
};