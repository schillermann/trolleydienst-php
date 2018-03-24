<?php
return function (array $configs): bool {

    $config_content = "<?php\n";
    $filter_define_value = include 'filter_define_value.php';

    foreach ($configs as $name => $value)
        $config_content .= "define('" . strtoupper($name) . "', ". $filter_define_value($value) .");\n";

    return (file_put_contents('config.php', $config_content) === false)? false: true;
};