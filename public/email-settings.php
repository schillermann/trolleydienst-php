<?php
$placeholder = require '../includes/init_page.php';

$placeholder['email_address_from'] = EMAIL_ADDRESS_FROM;
$placeholder['email_address_reply'] = EMAIL_ADDRESS_REPLY;
$placeholder['congregation_name'] = CONGREGATION_NAME;
$placeholder['application_name'] = APPLICATION_NAME;
$placeholder['team_name'] = TEAM_NAME;

$placeholder['email_dispatch'] = EMAIL_DISPATCH;
$placeholder['email_sendinblue_api_key'] = MAIL_SENDINBLUE_API_KEY;
$placeholder['email_smtp_host'] = SMTP_HOST;
$placeholder['email_smtp_username'] = SMTP_USERNAME;
$placeholder['email_smtp_password'] = SMTP_PASSWORD;
$placeholder['email_smtp_port'] = SMTP_PORT;
$placeholder['email_smtp_encryption'] = SMTP_ENCRYPTION;

if (isset($_POST['save'])) {

	$filter_post_input = require('../modules/filter_post_input.php');
	$input_fields = $filter_post_input();

    $write_config_file = require('../modules/write_config_file.php');
    $config = array(
        'EMAIL_ADDRESS_FROM' => $input_fields['email_address_from'],
        'EMAIL_ADDRESS_REPLY' => $input_fields['email_address_reply'],
        'CONGREGATION_NAME' => $input_fields['congregation_name'],
        'APPLICATION_NAME' => $input_fields['application_name'],
        'TEAM_NAME' => $input_fields['team_name'],
        'UPLOAD_SIZE_MAX_IN_MEGABYTE' => UPLOAD_SIZE_MAX_IN_MEGABYTE,
		'BAN_TIME_IN_MINUTES' => BAN_TIME_IN_MINUTES,
		'LOGIN_FAIL_MAX' => LOGIN_FAIL_MAX,
        'DEMO' => DEMO,
        'LANGUAGE' => LANGUAGE,
        'TIMEZONE' => TIMEZONE,

        'EMAIL_DISPATCH' => $input_fields['email_dispatch'],
        'MAIL_SENDINBLUE_API_KEY' => $input_fields['email_sendinblue_api_key'],
        'SMTP_HOST' => $input_fields['email_smtp_host'],
        'SMTP_USERNAME' => $input_fields['email_smtp_username'],
        'SMTP_PASSWORD' => $_POST['email_smtp_password'],
        'SMTP_PORT' => $input_fields['email_smtp_port'],
        'SMTP_ENCRYPTION' => $input_fields['email_smtp_encryption'],

        'MAINTENANCE' => MAINTENANCE,
    );
    if($write_config_file($config)) {
        $placeholder['email_address_from'] = $input_fields['email_address_from'];
        $placeholder['email_address_reply'] = $input_fields['email_address_reply'];
        $placeholder['congregation_name'] = $input_fields['congregation_name'];
        $placeholder['application_name'] = $input_fields['application_name'];
        $placeholder['team_name'] = $input_fields['team_name'];

        $placeholder['email_dispatch'] = $input_fields['email_dispatch'];
        $placeholder['email_sendinblue_api_key'] = $input_fields['email_sendinblue_api_key'];
        $placeholder['email_smtp_host'] = $input_fields['email_smtp_host'];
        $placeholder['email_smtp_username'] = $input_fields['email_smtp_username'];
        $placeholder['email_smtp_password'] = $_POST['email_smtp_password'];
        $placeholder['email_smtp_port'] = $input_fields['email_smtp_port'];
        $placeholder['email_smtp_encryption'] = $input_fields['email_smtp_encryption'];

        $placeholder['message']['success'] = __('The email placeholders have been written to the config.php file.');
    } else {
        $placeholder['message']['error'] = __('The email placeholders could not be written to the config.php file.');
    }
}

$render_page = require('../includes/render_page.php');
echo $render_page($placeholder);