<?php return function (string $text): string {
	$pattern = '!((http\:\/\/|ftp\:\/\/|https\:\/\/)|www\.)([-a-zA-Zа-яА-Я0-9\~\!\@\#\$\%\^\&\*\(\)_\-\=\+\\\/\?\.\:\;\'\,]*)?!ism';
	$replacement = '<a href="//$3" target="_blank">$1$3</a>';
	return preg_replace($pattern, $replacement, $text);
};