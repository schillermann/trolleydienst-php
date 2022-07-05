<?php return function (\PDO $connection, int $id_shift, \DateTimeInterface $shift_from, \DateTimeInterface $shift_to, string $shift_type_name, int $id_user): bool {

	$get_template_shift_promote = include '../services/get_email_template.php';
	$email_template = $get_template_shift_promote($connection, App\Tables\EmailTemplates::SHIFT_PROMOTE);
	$shift = App\Tables\Shifts::select($connection, $id_shift);

	$user_email = App\Tables\Users::select_email($connection, $id_user);
	$shift_date = $shift_from->format(__('d/m/Y') . ' H:i') . ' - ' . $shift_to->format('H:i');

	$subject_replace_with = array(
		'SHIFT_TYPE_NAME' => $shift_type_name
	);
	$message_replace_with = array(
		'SHIFT_TYPE_NAME' => $shift_type_name,
		'DATE' => $shift_date,
		'ROUTE' => $shift['route'],
		'WEBSITE_LINK' => 'http://' . $_SERVER['SERVER_NAME']
	);

	$email_template_subject = strtr($email_template['subject'], $subject_replace_with);
	$email_template_message = strtr($email_template['message'], $message_replace_with);

	$send_mail_plain = include '../modules/send_mail_plain.php';
	if($send_mail_plain($user_email, $email_template_subject, $email_template_message))
		return true;

	App\Tables\History::insert(
		$connection,
		$_SESSION['name'],
		App\Tables\History::SYSTEM_ERROR,
		__(
			'The shift appointment on %s for %s could not be sent!',
			[
				$shift_date,
				$user_email
			]
		)
	);
	return false;
};