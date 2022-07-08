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
        //Load Composer's autoloader
        require_once('../vendor/autoload.php');

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require '../vendor/PHPMailer/src/Exception.php';
        require '../vendor/PHPMailer/src/PHPMailer.php';
        require '../vendor/PHPMailer/src/SMTP.php';

        $mail = new PHPMailer;

        //Server settings
        if ( SMTP_DEBUG) {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;              // Enable verbose debug output
        }
        $mail->Host       = SMTP_HOST;                          //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                               //Enable SMTP authentication
        $mail->Username   = SMTP_USERNAME;                      //SMTP username
        $mail->Password   = SMTP_PASSWORD;                      //SMTP password
        if ( SMTP_ENCRYPTION == "ssl" ) {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;    //Enable implicit TLS encryption
        } else if ( SMTP_ENCRYPTION == "tls") {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        }
        $mail->Port       = SMTP_PORT;                          //TCP port to connect to

        //Recipients
        $mail->setFrom(EMAIL_ADDRESS_FROM, CONGREGATION_NAME . ' - ' . APPLICATION_NAME);
        $mail->addAddress($to);
        $mail->addReplyTo(EMAIL_ADDRESS_REPLY, TEAM_NAME);
        $mail->addBCC(EMAIL_ADDRESS_BCC);
        
        //Content
        $mail->isHTML(true);                                    //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = '<html><body>' . str_replace("||", "<br>", $message) . '</body></html>';

        if(!$mail->send()) {
            return false;
        } else {
            return true;
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