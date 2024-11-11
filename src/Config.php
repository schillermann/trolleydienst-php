<?php

namespace App;

include('../config.php');
class Config
{
    function congregation(): string
    {
        return defined('CONGREGATION_NAME') ? CONGREGATION_NAME : '';
    }

    function application(): string
    {
        return defined('APPLICATION_NAME') ? APPLICATION_NAME : '';
    }

    function banTimeInMinutes(): int
    {
        return defined('BAN_TIME_IN_MINUTES') ? BAN_TIME_IN_MINUTES : 0;
    }

    function team(): string
    {
        return defined('TEAM_NAME') ? TEAM_NAME : '';
    }

    function emailDispatch(): string
    {
        return defined('EMAIL_DISPATCH') ? strtolower(EMAIL_DISPATCH) : 'phpmail';
    }

    function emailSendinblueApiKey(): string
    {
        return defined('MAIL_SENDINBLUE_API_KEY') ? MAIL_SENDINBLUE_API_KEY : '';
    }

    function emailAddressFrom(): string
    {
        return defined('EMAIL_ADDRESS_FROM') ? EMAIL_ADDRESS_FROM : '';
    }

    function emailAddressReply(): string
    {
        return defined('EMAIL_ADDRESS_REPLY') ? EMAIL_ADDRESS_REPLY : '';
    }

    function loginFailsMax(): int
    {
        return defined('LOGIN_FAIL_MAX') ? LOGIN_FAIL_MAX : 0;
    }

    function smtpHost(): string
    {
        return defined('SMTP_HOST') ? SMTP_HOST : '';
    }

    function smtpUsername(): string
    {
        return defined('SMTP_USERNAME') ? SMTP_USERNAME : '';
    }

    function smtpPassword(): string
    {
        return defined('SMTP_PASSWORD') ? SMTP_PASSWORD : '';
    }

    function smtpPort(): int
    {
        return defined('SMTP_PORT') ? SMTP_PORT : 0;
    }

    function smtpTls(): bool
    {
        return defined('SMTP_ENCRYPTION') && 'tls' ? true : false;
    }

    function demo(): bool
    {
        return defined('DEMO') && DEMO === true;
    }
}
