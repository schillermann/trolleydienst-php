<?php
/**
 * return string Class name active or empty string
 */
return function (): string {

	$url_filename = basename($_SERVER['PHP_SELF']);

	foreach (func_get_args() as $filename)
		if($url_filename == $filename)
			return 'active';

	return '';
};