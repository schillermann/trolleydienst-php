<?php
return function (array $configs): bool {

    $config_content = "<?php\n";

    foreach ($configs as $name => $value)
        $config_content .= "define('" . strtoupper($name) . "', '". $value ."');\n";

    return (file_put_contents('config.php', $config_content) === false)? false: true;
};