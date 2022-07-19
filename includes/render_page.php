<?php
return function (array $placeholder = [], string $file_name = '') : string {
    $layout_placeholder = [];

    $page_file_name = (empty($file_name))? basename($_SERVER['SCRIPT_NAME']) : $file_name;
    $page_file_path = '../templates/pages/' . $page_file_name;
    $render_template = require('../modules/render_template.php');

    $layout_placeholder['template'] = $render_template($page_file_path, $placeholder);
    $layout_placeholder['shift_types'] = (isset($placeholder['shift_types']))? $placeholder['shift_types'] : array();

    $layout_file = '../templates/layout.php';
    $page_layout = require('../modules/render_template.php');
    return $page_layout($layout_file, $layout_placeholder);
};