<?php
session_start();
if(empty($_SESSION) || !isset($_GET['id_info'])) {
	header('location: /');
	return;
}
$id_info = (int)$_GET['id_info'];

spl_autoload_register();
$database_pdo = Tables\Database::get_connection();
$file_resource = Tables\InfoFiles::select($database_pdo, $id_info);
$mime_type = Tables\Infos::select_mime_type($database_pdo, $id_info);

if(empty($mime_type)) {
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime_type = finfo_buffer($finfo, $file_resource, FILEINFO_MIME_TYPE);
	finfo_close($finfo);
}
header('Content-type: ' . $mime_type);
echo $file_resource;