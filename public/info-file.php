<?php
session_start();
$baseUrl = include '../includes/get_base_uri.php';

if(empty($_SESSION) || !isset($_GET['id_info'])) {
	header('location: ' . $baseUrl);
	return;
}
$id_info = (int)$_GET['id_info'];

require __DIR__ . '/../vendor/autoload.php';
$database_pdo = App\Tables\Database::get_connection();
$file_resource = App\Tables\InfoFiles::select($database_pdo, $id_info);
$mime_type = App\Tables\Infos::select_mime_type($database_pdo, $id_info);

if(empty($mime_type)) {
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime_type = finfo_buffer($finfo, $file_resource, FILEINFO_MIME_TYPE);
	finfo_close($finfo);
}
header('Content-type: ' . $mime_type);
echo $file_resource;