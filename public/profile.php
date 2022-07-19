<?php
$placeholder = require '../includes/init_page.php';

if(isset($_POST['save'])) {
    if(DEMO) {
        $placeholder['message']['error'] = __('The profile cannot be changed in the demo version!');
    } else {
        $profile_filter_post_input = include '../modules/filter_post_input.php';
        $profile_update = new App\Models\Profile($_SESSION['id_user'], $profile_filter_post_input());

        if(App\Tables\Publisher::update_profile($database_pdo, $profile_update))
            $placeholder['message']['success'] = __('Your profile has been successfully updated.');
        else
            $placeholder['message']['error'] = __('Your profile could not be updated!');
    }
}

$placeholder['profile'] = App\Tables\Publisher::select_profile($database_pdo, $_SESSION['id_user']);
$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);