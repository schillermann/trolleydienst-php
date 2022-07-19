<?php
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

return function (string $to, string $subject, string $message): string {

    $htmlMessage = $message;
    $plainMessage = strip_tags($message);

    $email = (new Email())
        ->from(EMAIL_ADDRESS_FROM)
        ->to($to)
        ->subject($subject)
        ->text($plainMessage);

    if ($plainMessage !== $htmlMessage) {
        $email = $email->html($htmlMessage);
    }

    if (defined('EMAIL_ADDRESS_REPLY') && EMAIL_ADDRESS_REPLY) {
        $email = $email->replyTo(EMAIL_ADDRESS_REPLY);
    }

    try {
        (new Mailer(
            Transport::fromDsn(
                'smtp://' . SMTP_USERNAME . ':' . urlencode(SMTP_PASSWORD) . '@' . SMTP_HOST . ':' . SMTP_PORT
            )
        ))->send($email);

        return '';
    } catch (TransportExceptionInterface $e) {
        return $e->getMessage();
    }
};