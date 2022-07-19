<?php
$placeholder = require '../includes/init_page.php';
$placeholder['email'] = array();

if(isset($_POST['send']) && !empty($_POST['email_subject']) && !empty($_POST['email_message'])) {

    $placeholder['email']['subject'] = $_POST['email_subject'];
    $placeholder['email']['message'] = $_POST['email_message'];
    
    if(DEMO) {
        $placeholder['message']['error'] = __('Emails cannot be sent in the demo version!');
    } else {

        $placeholder['user_list'] = App\Tables\Publisher::select_all_email($database_pdo);

        if(!empty($placeholder['user_list'])) {

            foreach ($placeholder['user_list'] as $user) {
                $replace_with = array(
                    'NAME' => $user['first_name'] . ' ' . $user['last_name'],
                    'WEBSITE_LINK' => 'http://' . $_SERVER['SERVER_NAME'] . '?username=' . urlencode($user['username'])
                );
                $email_message = strtr($placeholder['email']['message'], $replace_with);

                $send_email = require('../modules/send_email.php');
                if($send_email($user['email'], $placeholder['email']['subject'], $email_message))
                    $placeholder['user_list'][] = $user;
            }
        }  
    }
} else {
    $get_email_template = require('../services/get_email_template.php');
    $placeholder['email'] = $get_email_template($database_pdo);
}

$render_page = require('../includes/render_page.php');
echo $render_page($placeholder);