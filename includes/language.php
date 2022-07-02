<?php

function __(string $text, array $args = []) {
	
	$language = include '../helpers/get_language.php';
	$languageFile = '../language/' . $language . '.php';

	if (!is_readable($languageFile)) {
		return vsprintf(
			$text,
			$args
		);
	}

	$translation = include($languageFile);

	if ( array_key_exists($text, $translation) ) {
		return vsprintf(
			$translation[$text],
			$args
		);
	} else {
		return vsprintf(
			$text,
			$args
		);
	}
}