<?php
$baseUrl = include '../includes/get_base_uri.php';

if(!isset($_GET['id_info'])) {
    header('location: ' . $baseUrl . '/info.php');
    return;
}

$placeholder = require '../includes/init_page.php';
$id_info = (int)$_GET['id_info'];

if(isset($_POST['delete'])) {

    if(DEMO) {
        $placeholder['message']['error'] = __('In der Demo Version darf die Datei nicht gelöscht werden!');
    } else {
        if(App\Tables\Infos::delete($database_pdo, $id_info)) {
            header('location: ' . $baseUrl . '/info.php');
            return;
        }
        $file_label = include '../filters/post_info_file_label.php';
        $placeholder['message']['error'] = __('Die Datei ') . $file_label . __(' konnte nicht gelöscht werden!');
    }
}
elseif (isset($_POST['save'])) {
    
    if(DEMO) {
        $placeholder['message']['error'] = __('In der Demo Version darf die Datei nicht bearbeitet werden!');
    } else {
        $file_label = include '../filters/post_info_file_label.php';

        if($file_label)
            if(App\Tables\Infos::update($database_pdo, $id_info, $file_label))
                $placeholder['message']['success'] = __('Die Datei wurde in "') . $file_label . __('" umbenannt.');
            else
                $placeholder['message']['error'] = __('Die Datei konnte nicht in "') . $file_label . __('" umbennant werden!');
    }
}

$placeholder['info_file_label'] = App\Tables\Infos::select_label($database_pdo, $id_info);

$render_page = include '../includes/render_page.php';
echo $render_page($placeholder);