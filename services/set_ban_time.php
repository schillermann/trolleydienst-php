<?php return function (\PDO $connection, int $login_fail_max): bool {

	$user_ip_address = include 'modules/get_ip_address.php';

	if(!Tables\LoginFails::update_fail($connection, $user_ip_address))
		Tables\LoginFails::insert($connection, $user_ip_address);

	$number_of_fails = Tables\LoginFails::select_fail($connection, $user_ip_address);
	if($number_of_fails > $login_fail_max)
		return Tables\LoginFails::update_ban($connection, $user_ip_address);
	else
		return false;
};