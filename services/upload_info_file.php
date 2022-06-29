<?php return function (\PDO $connection, string $file_label, string $file_tmp_path, string $mime_type, int $file_size): bool {

	$mime_type_list_allow = array('image/jpeg', 'image/png', 'image/gif', 'application/pdf');

	if(!in_array($mime_type, $mime_type_list_allow))
		return false;
	if(strpos($mime_type, 'image') !== false && !getimagesize($file_tmp_path))
		return false;

	$file_size_max_byte = UPLOAD_SIZE_MAX_IN_MEGABYTE * 1024 * 1024;

	if($file_size > $file_size_max_byte)
		return false;

	$id_info = App\Tables\Infos::insert($connection, $file_label, $mime_type);
	if($id_info == 0)
		return false;

	$file_resource = fopen($file_tmp_path, 'rb');
	$is_file_insert = App\Tables\InfoFiles::insert($connection, $id_info, $file_resource);
	fclose($file_resource);
	unlink($file_tmp_path);

	return $is_file_insert;
};