<?php
$placeholder = require '../includes/init_page.php';
$baseUrl = include '../includes/get_base_uri.php';

if(!isset($_GET['id_email_template'])) {
	header('location: ' . $baseUrl . '/email.php');
	return;
}

$id_email_template = (int)$_GET['id_email_template'];

if(isset($_POST['save'])) {
	$template_email_subject = include '../filters/post_template_email_subject.php';
	$template_email_message = include '../filters/post_template_email_message.php';

	if(App\Tables\EmailTemplates::update($database_pdo, $id_email_template, $template_email_message, $template_email_subject))
		$placeholder['message']['success'] = 'Die Vorlage ' . $template_email_subject . ' wurde gespeichert.';
	else
		$placeholder['message']['error'] = 'Die Vorlage ' . $template_email_subject . ' konnte nicht gespeichert werden!';
}

$placeholder['email_templates'] = App\Tables\EmailTemplates::select_all($database_pdo);
$placeholder['selected_template'] = App\Tables\EmailTemplates::select($database_pdo, $id_email_template);
$placeholder['id_email_template'] = $id_email_template;

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);