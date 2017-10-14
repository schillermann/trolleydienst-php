<?php return function (string $text): string {
	$parse_text_to_html = include 'parse_link.php';
	return nl2br($parse_text_to_html($text));
};