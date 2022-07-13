<?php
return function ($to, $subject, $message): bool {
    if ( SMTP == "php" ) {
        return function ($to, $subject, $message): bool {
            $headers   = [];
            $headers[] = 'Content-type: text/plain; charset=utf-8';
            $headers[] = 'From: =?UTF-8?B?'.base64_encode(APPLICATION_NAME . ' - ' . CONGREGATION_NAME).'?=<' . EMAIL_ADDRESS_FROM . '>';
            $headers[] = 'Reply-To: ' . TEAM_NAME . ' <' . EMAIL_ADDRESS_REPLY . '>';
        
            return mail($to, $subject, $message, implode("\r\n",$headers));
        };
    } else if ( SMTP == "smtp" ) {
        require_once('../helpers/symfony_mailer.php');
            try {
                $mailer->send($email);
                return true;
            } catch (TransportExceptionInterface $e) {
                return false;
            }
    } else if ( SMTP == "sendinblue" ) {
        //Load Composer's autoloader
        require_once('../vendor/autoload.php');

        $credentials = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', MAIL_SENDINBLUE_API_KEY);
        $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(new GuzzleHttp\Client(),$credentials);
        
        $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
            'subject' => $subject,
            'sender' => ['name' => CONGREGATION_NAME . ' - ' . APPLICATION_NAME, 'email' => EMAIL_ADDRESS_FROM],
            'replyTo' => ['name' => TEAM_NAME, 'email' => EMAIL_ADDRESS_REPLY],
            'to' => [[ 'email' => $to]],
            'htmlContent' => '<html><body>' . str_replace("||", "<br>", $message) . '</body></html>'
       ]);
    
       try {
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
};