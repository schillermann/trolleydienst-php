<?php
$placeholder = require 'includes/init_page.php';
$render_page = include 'includes/render_page.php';

$page_file = '';

if(isset($_POST['save'])) {

    $username = include 'filters/post_username.php';

    if(Tables\Users::is_username($database_pdo, $username)) {
        $placeholder['message']['error'] = 'Der Name ist bereits vergeben!';
    } else {
        $get_password = require 'modules/random_string.php';
        $password = $get_password(8);
        $email = include 'filters/post_email.php';

        $user = new Models\User(
            0,
            include 'filters/post_name.php',
            $email,
            $password,
            include 'filters/post_is_admin.php',
            true,
            include 'filters/post_phone.php',
            include 'filters/post_mobile.php',
            include 'filters/post_congregation_name.php',
            include 'filters/post_language.php',
            include 'filters/post_note_admin.php'
        );
    }


    if(Tables\Users::is_username($database_pdo, $username))
        $placeholder['message']['error'] = 'Der Name ist bereits vergeben!';
    elseif (!Tables\Users::insert($database_pdo, $user))
        $placeholder['message']['error'] = 'Der Teilnehmer konnte nicht angelegt werden!';

    if(empty($placeholder['message']['error'])) {
        $page_file = 'user-add-mail.php';

        $placeholder['email'] = $email;
        $placeholder['username'] = $username;
        $placeholder['password'] = $password;

        //TODO: Send mail to added user
    }
}

echo $render_page($placeholder, $page_file);