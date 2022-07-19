<?php
return function (string $template_file_path, array $placeholder = []): string {

    $page_content = '';

    ob_start();
    require($template_file_path);
    $page_content = ob_get_contents();
    ob_end_clean();

    return $page_content;
};