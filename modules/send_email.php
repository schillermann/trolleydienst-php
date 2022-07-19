<?php
return function (string $to, string $subject, string $message): string {
    $send_email = require('send_email_' . strtolower(EMAIL_DISPATCH) . '.php');
    return $send_email($to, $subject, $message);
};