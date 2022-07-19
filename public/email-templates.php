<?php
$placeholder = require '../includes/init_page.php';

if(!isset($_GET['id_email_template'])) {
	header('location: /email.php');
	return;
}

$id_email_template = (int)$_GET['id_email_template'];

if(isset($_POST['save'])) {
	$template_email_subject = require('../filters/post_template_email_subject.php');
	$template_email_message = require('../filters/post_template_email_message.php');

	if(App\Tables\EmailTemplates::update($database_pdo, $id_email_template, $template_email_message, $template_email_subject))
		$placeholder['message']['success'] = __('The template %s has been saved.', [ $template_email_subject ]);
	else
		$placeholder['message']['error'] = __('The template %s could not be saved!', [ $template_email_subject ]);
}

$placeholder['email_templates'] = App\Tables\EmailTemplates::select_all($database_pdo);
$placeholder['selected_template'] = App\Tables\EmailTemplates::select($database_pdo, $id_email_template);
$placeholder['id_email_template'] = $id_email_template;

$render_page = require('../includes/render_page.php');
echo $render_page($placeholder);