<?php return function (): bool {
    return (file_put_contents('config.php', "\ndefine('DEMO', false);", FILE_APPEND) === false)? false : true;
};