<?php
	if ( !function_exists('__') ) {
		function __($string) {
			if ( LANG == "de" ) {
				return $string;
			}
			
			include '../includes/lang/' . LANG . '.lang.php';	
			
			if ( array_key_exists($string, $language) ) {
				return $language[$string];
			} else {
				return $string;
			}
		}
	}