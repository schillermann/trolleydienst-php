<?php
return function (\PDO $database_pdo, string $name, string $password): bool {

    $user = Tables\Users::select_logindata($database_pdo, $name, $password);

    if(empty($user))
        return false;

	$user_ip_address = include 'modules/get_ip_address.php';
    Tables\LoginFails::delete($database_pdo, $user_ip_address);

    $_SESSION['id_user'] = (int)$user['id_user'];
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $user['email'];
    $_SESSION['is_admin'] = (bool)$user['is_admin'];

    Tables\Users::update_login_time($database_pdo, $_SESSION['id_user']);

    return true;
};