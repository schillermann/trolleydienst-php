<?php
if(!isset($_GET['id_user'])) {
    header('location: user.php');
    return;
}

$placeholder = require 'includes/init_page.php';
$id_user = (int)$_GET['id_user'];

if (isset($_POST['save'])) {
    $user = new Models\User(
        $id_user,
        include 'filters/post_username.php',
        include 'filters/post_name.php',
        include 'filters/post_email.php',
        '',
        include 'filters/post_is_admin.php',
        include 'filters/post_is_active.php',
        include 'filters/post_phone.php',
        include 'filters/post_mobile.php',
        include 'filters/post_congregation_name.php',
        include 'filters/post_language.php',
        include 'filters/post_note_admin.php'
    );

    if(Tables\Users::update_user($database_pdo, $user)) {
        header('location: user.php');
        return;
    } else
        $placeholder['message']['error'] = 'Die Teilnehmer Daten konnten nicht geändert werden!';
} elseif (isset($_POST['delete'])) {
    if(Tables\Users::delete($database_pdo, $id_user)) {
        header('location: user.php');
        return;
    }
} elseif(isset($_POST['password_save']) && !empty($_POST['password'])) {

    if($_POST['password'] == $_POST['password_repeat'])
        if(Tables\Users::update_password($database_pdo, $id_user, $_POST['password']))
            $placeholder['message']['success'] = 'Dein Passwort wurde geändert.';
        else
            $placeholder['message']['error'] = 'Dein Passwort konnte nicht geändert werden!';
    else
        $placeholder['message']['error'] = 'Passwörter stimmen nicht überein!';
}

$placeholder['user'] = Tables\Users::select_user($database_pdo, $id_user);

$user_updated = new \DateTime($placeholder['user']['updated']);
$user_created = new \DateTime($placeholder['user']['created']);
$placeholder['user']['updated'] = $user_updated->format('d.m.Y H:i');
$placeholder['user']['created'] = $user_created->format('d.m.Y H:i');

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);