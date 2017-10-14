<?php
return function (array $placeholder = array(), string $file_name = '') : string {
    $layout_placeholder = array();

    $page_file_name = (empty($file_name))? basename($_SERVER['SCRIPT_NAME']) : $file_name;
    $page_file_path = 'templates/pages/' . $page_file_name;
    $render_template = include 'modules/render_template.php';

    $layout_placeholder['template'] = $render_template($placeholder, $page_file_path);
    $layout_placeholder['shift_types'] = (isset($placeholder['shift_types']))? $placeholder['shift_types'] : array();

    $layout_file = 'templates/layout.php';
    $page_layout = include 'modules/render_template.php';
    return $page_layout($layout_placeholder, $layout_file);
};