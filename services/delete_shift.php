<?php return function (\PDO $connection, int $id_shift): bool {

	$shift_datetime = App\Tables\Shifts::select_datetime_from($connection, $id_shift);

	if(!App\Tables\Shifts::delete($connection, $id_shift))
		return false;

	$user_list_from_shift = App\Tables\ShiftUserMaps::select_all_with_id_shift($connection, $id_shift);

	foreach ($user_list_from_shift as $user) {

		$get_template_email_user_promote = require('../services/get_email_template.php');
		$email_template = $get_template_email_user_promote($connection, App\Tables\EmailTemplates::SHIFT_DELETE);

		$replace_with = array(
			'NAME' => $user['name'],
			'SHIFT_DATE' => $shift_datetime->format(__('d/m/Y'))
		);

		$email_template_message = strtr($email_template['message'], $replace_with);

		$send_email = require('../modules/send_email.php');
		if(!$send_email($user['email'], $email_template['subject'], $email_template_message)) {
			App\Tables\History::insert(
				$connection,
				$_SESSION['name'],
				App\Tables\History::SYSTEM_ERROR,
				__(
					'The notification for the deleted shift on %s for %s with the email address %s failed to send!',
					[
						$shift_datetime->format(__('d/m/Y')),
						$user['name'],
						$user['email']
					]
				)
			);
		}
	}

	return App\Tables\ShiftUserMaps::delete_shift($connection, $id_shift);
};