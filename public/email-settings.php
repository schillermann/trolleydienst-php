<?php
$placeholder = require '../includes/init_page.php';

$placeholder['email_address_from'] = EMAIL_ADDRESS_FROM;
$placeholder['email_address_reply'] = EMAIL_ADDRESS_REPLY;
$placeholder['congregation_name'] = CONGREGATION_NAME;
$placeholder['application_name'] = APPLICATION_NAME;
$placeholder['team_name'] = TEAM_NAME;

if (isset($_POST['save'])) {

	$filter_post_input = include '../modules/filter_post_input.php';
	$input_fields = $filter_post_input();

    $write_config_file = include '../modules/write_config_file.php';
    $config = array(
        'EMAIL_ADDRESS_FROM' => $input_fields['email_address_from'],
        'EMAIL_ADDRESS_REPLY' => $input_fields['email_address_reply'],
        'CONGREGATION_NAME' => $input_fields['congregation_name'],
        'APPLICATION_NAME' => $input_fields['application_name'],
        'TEAM_NAME' => $input_fields['team_name'],
        'UPLOAD_SIZE_MAX_IN_MEGABYTE' => UPLOAD_SIZE_MAX_IN_MEGABYTE,
		'BAN_TIME_IN_MINUTES' => BAN_TIME_IN_MINUTES,
		'LOGIN_FAIL_MAX' => LOGIN_FAIL_MAX
    );
    if($write_config_file($config)) {
        $placeholder['email_address_from'] = $input_fields['email_address_from'];
        $placeholder['email_address_reply'] = $input_fields['email_address_reply'];
        $placeholder['congregation_name'] = $input_fields['congregation_name'];
        $placeholder['application_name'] = $input_fields['application_name'];
        $placeholder['team_name'] = $input_fields['team_name'];

        $placeholder['message']['success'] = __('The email placeholders have been written to the config.php file.');
    } else {
        $placeholder['message']['error'] = __('The email placeholders could not be written to the config.php file.');
    }
}

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);