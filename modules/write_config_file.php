<?php
return function (array $configs): bool {

    $config_content = "<?php\n";

    foreach ($configs as $name => $value) {
        switch (gettype($value)) {
            case 'boolean':
                if($value)
                    $define_value = 'true';
                else
                    $define_value = 'false';
                break;
            case 'integer':
                $define_value = $value;
                break;
            default:
                $define_value = "'" . $value . "'";
        }
        
        $config_content .= "define('" . strtoupper($name) . "', ". $define_value .");\n";
    }

    return (file_put_contents('config.php', $config_content) === false)? false: true;
};