<?php

use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\SendSmtpEmail;

return function (string $to, string $subject, string $message): string {
   
    try {
        (new TransactionalEmailsApi(
            new GuzzleHttp\Client(),
            Configuration::getDefaultConfiguration()->setApiKey(
                'api-key',
                MAIL_SENDINBLUE_API_KEY
            )
        ))
            ->sendTransacEmail(
                new SendSmtpEmail([
                    'subject' => $subject,
                    'sender' => ['name' => CONGREGATION_NAME . ' - ' . APPLICATION_NAME, 'email' => EMAIL_ADDRESS_FROM],
                    'replyTo' => ['name' => TEAM_NAME, 'email' => EMAIL_ADDRESS_REPLY],
                    'to' => [[ 'email' => $to]],
                    'htmlContent' => '<html><body>' . str_replace("||", "<br>", $message) . '</body></html>'
                ])
            );
        return '';
    } catch (\Exception $e) {
        return $e->getMessage();
    }
};