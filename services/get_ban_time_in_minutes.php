<?php return function (\PDO $connection, int $ban_minutes): int {

	$user_ip_address = include '../modules/get_ip_address.php';

	$ban_datetime_string = App\Tables\LoginFails::select_ban($connection, $user_ip_address);
	if(empty($ban_datetime_string))
		return 0;

	$ban_datetime = new \DateTime($ban_datetime_string);
	$datetime_now = new \DateTime('now', new DateTimezone('Europe/Berlin'));

	$ban_datetime_diff = $ban_datetime->diff($datetime_now);
	$ban_datetime_diff_in_minutes = (int)$ban_datetime_diff->format('%i');

	$remaining_ban_time = $ban_minutes - $ban_datetime_diff_in_minutes;

	if($remaining_ban_time <= 0) {
		App\Tables\LoginFails::delete($connection, $user_ip_address);
		return 0;
	}

	return $remaining_ban_time;
};