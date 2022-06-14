<?php
return function (string $filter_folder = '../filters'): array {

    $return_value_list = array();

    foreach ($_POST as $input_field_name => $value) {
        $filter_file = $filter_folder . '/post_' . $input_field_name . '.php';
        if(file_exists($filter_file))
            $return_value_list[$input_field_name] = include $filter_file;
    }

    return $return_value_list;
};