<?php return function (\PDO $connection, int $id_shift, int $position, int $id_user, \DateTimeInterface $shift_datetime, int $id_email_template = App\Tables\EmailTemplates::APPLICATION_ACCEPT) {

	$user_name = App\Tables\Publisher::select_name($connection, $id_user);
	$user_list_from_shift_postion = App\Tables\ShiftUserMaps::select_all_with_id_shift_and_position($connection, $id_shift, $position);

	foreach ($user_list_from_shift_postion as $user) {
		if($user['id'] == $id_user)
			continue;

		$get_template_email_user_promote = include '../services/get_email_template.php';
		$email_template = $get_template_email_user_promote($connection, $id_email_template);

		$replace_with = array(
			'NAME' => $user['first_name'] . ' ' . $user['last_name'],
			'APPLICANT_NAME' => $user_name,
			'SHIFT_DATE' => $shift_datetime->format(__('d/m/Y')),
			'WEBSITE_LINK' => 'http://' . $_SERVER['SERVER_NAME']
		);

		$email_template_message = strtr($email_template['message'], $replace_with);

		$send_email = require('../modules/send_email.php');
		if(!empty($send_email($user['email'], $email_template['subject'], $email_template_message))) {
			App\Tables\History::insert(
				$connection,
				$_SESSION['name'],
				App\Tables\History::SYSTEM_ERROR,
				__(
					'The information email for %s with the email address %s could not be sent!',
					[
						$user['first_name'] . ' ' . $user['last_name'],
						$user['email']
					]
				)
			);
		}

	}
};