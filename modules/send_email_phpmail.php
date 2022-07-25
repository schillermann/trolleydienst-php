<?php

return function (string $to, string $subject, string $message): string {
    if ( EMAIL_DISPATCH == "phpmail" ) {
        $headers   = [];
        $headers[] = 'Content-type: text/plain; charset=utf-8';
        $headers[] = 'From: =?UTF-8?B?'.base64_encode(APPLICATION_NAME . ' - ' . CONGREGATION_NAME).'?=<' . EMAIL_ADDRESS_FROM . '>';
        $headers[] = 'Reply-To: ' . TEAM_NAME . ' <' . EMAIL_ADDRESS_REPLY . '>';
    
        if(mail($to, $subject, $message, implode("\r\n",$headers))) {
            return '';
        }

        return 'E-mail could not be sent.';
    }
};