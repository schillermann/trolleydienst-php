<?php
if (!empty($_SERVER['HTTP_CLIENT_IP']))  //check ip from share internet
	return $_SERVER['HTTP_CLIENT_IP'];

if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	return $_SERVER['HTTP_X_FORWARDED_FOR'];

return $_SERVER['REMOTE_ADDR'];