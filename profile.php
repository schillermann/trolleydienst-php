<?php
$placeholder = require 'includes/init_page.php';

if(isset($_POST['save'])) {

    $profile_filter_post_input = include 'modules/filter_post_input.php';
    $profile_update = new Models\Profile($_SESSION['id_user'], $profile_filter_post_input());

    if(Tables\Users::update_profile($database_pdo, $profile_update))
        $placeholder['message']['success'] = 'Dein Benutzerdaten wurde gespeichert.';
    else
        $placeholder['message']['error'] = 'Dein Benutzerdaten konnte nicht gespeichert werden!';
}

$placeholder['profile'] = Tables\Users::select_profile($database_pdo, $_SESSION['id_user']);
$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);