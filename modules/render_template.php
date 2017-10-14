<?php
return function (array $placeholder = array(), string $template_file_path): string {

    $page_content = '';

    ob_start();
    include $template_file_path;
    $page_content = ob_get_contents();
    ob_end_clean();

    return $page_content;
};