<?php

function __(string $text, array $args = []) {
	
	$language = require('../helpers/get_language.php');
	$languageFile = '../language/' . $language . '.php';

	if (!is_readable($languageFile)) {
		return vsprintf(
			$text,
			$args
		);
	}

	$translation = require($languageFile);

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