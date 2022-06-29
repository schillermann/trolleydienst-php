<?php return function (string $message): string {
	$filter_ip = include '../modules/filter_ip.php';
	$ip = $filter_ip($message);
	$urlencode_ip = $ip;

	if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
		$urlencode_ip = urlencode($ip);

	$geo_ip_link = '<a target="_blank" href="https://tools.keycdn.com/geo?host=' . $urlencode_ip . '">' . $ip . '</a>';

	return str_replace($ip, $geo_ip_link, $message);
};