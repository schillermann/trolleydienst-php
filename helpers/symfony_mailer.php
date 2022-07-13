<?php
namespace App\Controller;

require_once('../vendor/autoload.php');

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

$transport = Transport::fromDsn('smtp://' . SMTP_USERNAME . ':' . SMTP_PASSWORD . '@' . SMTP_HOST . ':' . SMTP_PORT);
$mailer = new Mailer($transport);

$email = (new Email())
->from(EMAIL_ADDRESS_FROM)
->to($to)
//->cc('cc@example.com')
//->bcc('bcc@example.com')
->replyTo(EMAIL_ADDRESS_REPLY)
//->priority(Email::PRIORITY_HIGH)
->subject($subject)
->text(str_replace("||", "", $message))
->html('<html><body>' . str_replace("||", "<br>", $message) . '</body></html>');