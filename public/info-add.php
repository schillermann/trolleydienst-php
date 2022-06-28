<?php
$placeholder = require '../includes/init_page.php';

if(isset($_POST['upload'])) {
    if(DEMO) {
        $placeholder['message']['error'] = __('In der Demo Version darf keine Datei hochgeladen werden!');
    } else {
        $upload_info_file = include '../services/upload_info_file.php';
        if($upload_info_file(
            $database_pdo,
            include '../filters/post_info_file_label.php',
            $_FILES['file']['tmp_name'],
            $_FILES['file']['type'],
            $_FILES['file']['size']
        ))
            $placeholder['message']['success'] = __('Die Datei wurde hochgeladen.');
	else
            $placeholder['message']['error'] = __('Die Datei konnte nicht hochgeladen werden!');
    }
}

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);