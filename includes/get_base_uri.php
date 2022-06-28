<?php 
$baseUri = dirname($_SERVER['PHP_SELF']);
return (strlen($baseUri) > 1)? $baseUri : '';