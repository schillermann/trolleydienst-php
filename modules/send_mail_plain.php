<?php
return function ($to, $subject, $message): bool {

    $headers   = [];
    $headers[] = 'Content-type: text/plain; charset=utf-8';
    $headers[] = 'From: =?UTF-8?B?'.base64_encode(APPLICATION_NAME . ' - ' . CONGREGATION_NAME).'?=<' . EMAIL_ADDRESS_FROM . '>';
    $headers[] = 'Reply-To: ' . TEAM_NAME . ' <' . EMAIL_ADDRESS_REPLY . '>';

    return mail($to, $subject, $message, implode("\r\n",$headers));
};