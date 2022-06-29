<?php
$placeholder = require '../includes/init_page.php';

if(isset($_POST['save']) && !empty($_POST['password'])) {
    if(DEMO) {
        $placeholder['message']['error'] = __('In der Demo Version darf das Passwort nicht geändert werden!');
    } else {
        if($_POST['password'] == $_POST['password_repeat'])
            if(App\Tables\Users::update_password($database_pdo, $_SESSION['id_user'], $_POST['password']))
                $placeholder['message']['success'] = __('Dein Passwort wurde geändert.');
            else
                $placeholder['message']['error'] = __('Dein Passwort konnte nicht geändert werden!');
        else
            $placeholder['message']['error'] = __('Passwörter stimmen nicht überein!');
    }
}

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);