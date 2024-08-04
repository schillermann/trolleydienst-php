<?php
return function (\PDO $database_pdo, string $email_or_username, string $password): bool {

    $user = App\Tables\Publisher::select_logindata($database_pdo, $email_or_username, $password);

    if (empty($user))
        return false;

    $user_ip_address = require('../modules/get_ip_address.php');
    App\Tables\LoginFails::delete($database_pdo, $user_ip_address);

    $_SESSION['publisher_id'] = (int)$user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['firstname'] = $user['firstname'];
    $_SESSION['lastname'] = $user['lastname'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['phone'] = $user['phone'];
    $_SESSION['mobile'] = $user['mobile'];
    $_SESSION['congregation'] = $user['congregation'];
    $_SESSION['language'] = $user['language'];
    $_SESSION['publisher_note'] = $user['publisher_note'];
    $_SESSION['admin_note'] = $user['admin_note'];
    $_SESSION['active'] = (bool)$user['active'];
    $_SESSION['admin'] = (bool)$user['admin'];
    $_SESSION['logged_on'] = $user['logged_on'];
    $_SESSION['updated_on'] = $user['updated_on'];
    $_SESSION['created_on'] = $user['created_on'];

    App\Tables\Publisher::update_login_time($database_pdo, (int)$user['id']);

    return true;
};
