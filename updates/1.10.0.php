<?php return function (\PDO $connection): bool {

    $config = [
        'EMAIL_ADDRESS_FROM' => EMAIL_ADDRESS_FROM,
        'EMAIL_ADDRESS_REPLY' => EMAIL_ADDRESS_REPLY,
        'CONGREGATION_NAME' => CONGREGATION_NAME,
        'APPLICATION_NAME' => APPLICATION_NAME,
        'TEAM_NAME' => TEAM_NAME,
        'UPLOAD_SIZE_MAX_IN_MEGABYTE' => UPLOAD_SIZE_MAX_IN_MEGABYTE,
        'BAN_TIME_IN_MINUTES' => BAN_TIME_IN_MINUTES,
        'LOGIN_FAIL_MAX' => LOGIN_FAIL_MAX,
        'DEMO' => DEMO,
        'LANGUAGE' => include('../helpers/get_language.php'),
        'TIMEZONE' => TIMEZONE,
        'SMTP' => 'php',
        'MAIL_SENDINBLUE_API_KEY' => '',
        'SMTP_HOST' => '',
        'SMTP_USERNAME' => '',
        'SMTP_PASSWORD' => '',
        'SMTP_PORT' => 587,
        'SMTP_ENCRYPTION' => 'tls',
        'MAINTENANCE' => false,
    ];

    $write_config_file = include '../modules/write_config_file.php';
    return $write_config_file($config);
};