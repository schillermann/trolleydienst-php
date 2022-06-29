<?php return function (\PDO $connection, int $login_fail_max): bool {

	$user_ip_address = include '../modules/get_ip_address.php';

	if(!App\Tables\LoginFails::update_fail($connection, $user_ip_address))
		App\Tables\LoginFails::insert($connection, $user_ip_address);

	$number_of_fails = App\Tables\LoginFails::select_fail($connection, $user_ip_address);
	if($number_of_fails > $login_fail_max)
		return App\Tables\LoginFails::update_ban($connection, $user_ip_address);
	else
		return false;
};