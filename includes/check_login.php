<?php
return function (\PDO $database_pdo, string $email, string $password): bool {

    $user = App\Tables\Users::select_logindata($database_pdo, $email, $password);

    if(empty($user))
        return false;

	$user_ip_address = include '../modules/get_ip_address.php';
    App\Tables\LoginFails::delete($database_pdo, $user_ip_address);

    $_SESSION['id_user'] = (int)$user['id_user'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['is_admin'] = (bool)$user['is_admin'];

    App\Tables\Users::update_login_time($database_pdo, $_SESSION['id_user']);

    return true;
};