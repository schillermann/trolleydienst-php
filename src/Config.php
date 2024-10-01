<?php

namespace App;

include('../config.php');
class Config
{
    public function congregation(): string
    {
        return defined('CONGREGATION_NAME') ? CONGREGATION_NAME : '';
    }

    public function application(): string
    {
        return defined('APPLICATION_NAME') ? APPLICATION_NAME : '';
    }

    public function team(): string
    {
        return defined('TEAM_NAME') ? TEAM_NAME : '';
    }

    public function emailDispatch(): string
    {
        return defined('EMAIL_DISPATCH') ? strtolower(EMAIL_DISPATCH) : 'phpmail';
    }

    public function emailSendinblueApiKey(): string
    {
        return defined('MAIL_SENDINBLUE_API_KEY') ? MAIL_SENDINBLUE_API_KEY : '';
    }

    public function emailAddressFrom(): string
    {
        return defined('EMAIL_ADDRESS_FROM') ? EMAIL_ADDRESS_FROM : '';
    }

    public function emailAddressReply(): string
    {
        return defined('EMAIL_ADDRESS_REPLY') ? EMAIL_ADDRESS_REPLY : '';
    }

    public function smtpHost(): string
    {
        return defined('SMTP_HOST') ? SMTP_HOST : '';
    }

    public function smtpUsername(): string
    {
        return defined('SMTP_USERNAME') ? SMTP_USERNAME : '';
    }

    public function smtpPassword(): string
    {
        return defined('SMTP_PASSWORD') ? SMTP_PASSWORD : '';
    }

    public function smtpPort(): int
    {
        return defined('SMTP_PORT') ? SMTP_PORT : 0;
    }

    public function smtpTls(): bool
    {
        return defined('SMTP_ENCRYPTION') && 'tls' ? true : false;
    }

    public function demo(): bool
    {
        return defined('DEMO') && DEMO === true;
    }
}
