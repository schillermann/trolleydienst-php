<?php
$placeholder = require '../includes/init_page.php';

if(isset($_POST['save']) && !empty($_POST['password'])) {
    if(DEMO) {
        $placeholder['message']['error'] = __('Passwords cannot be changed in the demo version!');
    } else {
        if($_POST['password'] == $_POST['password_repeat'])
            if(App\Tables\Users::update_password($database_pdo, $_SESSION['id_user'], $_POST['password']))
                $placeholder['message']['success'] = __('Your password has been changed successfully.');
            else
                $placeholder['message']['error'] = __('Your password could not be changed!');
        else
            $placeholder['message']['error'] = __('Passwords do not match!');
    }
}

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);