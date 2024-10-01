<?php

namespace App\Api;

use App\Config;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\SendSmtpEmail;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\SendmailTransport;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class EmailSendPost implements PageInterface
{
    public function __construct(
        private Config $config,
        private string $to = '',
        private string $subject = '',
        private string $text = '',
        private string $html = ''
    ) {
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $email = (new Email())
            ->from(
                Address::create(
                    "{$this->config->application()} - {$this->config->congregation()} <{$this->config->emailAddressFrom()}>"
                )
            )
            ->replyTo(
                Address::create(
                    "{$this->config->team()} <{$this->config->emailAddressReply()}>"
                )
            )
            ->to($this->to)
            ->subject($this->subject);

        if ($this->text) {
            $email->text($this->text);
        }
        if ($this->html) {
            $email->html($this->html);
        }

        switch ($this->config->emailDispatch()) {
            case 'smtp':
                $transport = new EsmtpTransport($this->config->smtpHost(), $this->config->smtpPort(), $this->config->smtpTls());
                $transport->setUsername($this->config->smtpUsername());
                $transport->setPassword($this->config->smtpPassword());
                break;
            case 'sendinblue':
                $this->sendOverSendinblue();
                break;
            default:
                $transport = new SendmailTransport();
        }

        $mailer = new Mailer($transport);
        $mailer->send($email);

        return $output->withMetadata(
            PageInterface::STATUS,
            PageInterface::STATUS_200_OK
        );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::BODY) {
            $body = json_decode($value, true);
            return new self(
                $this->config,
                $body['to'],
                $body['subject'],
                isset($body['text']) ? $body['text'] : '',
                isset($body['html']) ? $body['html'] : ''
            );
        }

        return $this;
    }

    public function sendOverSendinblue(): void
    {
        (new TransactionalEmailsApi(
            new \GuzzleHttp\Client(),
            Configuration::getDefaultConfiguration()->setApiKey(
                'api-key',
                $this->config->emailSendinblueApiKey()
            )
        ))
            ->sendTransacEmail(
                new SendSmtpEmail([
                    'subject' => $this->subject,
                    'sender' => [
                        'name' => "{$this->config->congregation()} - {$this->config->application()}",
                        'email' => $this->config->emailAddressFrom()
                    ],
                    'replyTo' => ['name' => $this->config->team(), 'email' => $this->config->emailAddressReply()],
                    'to' => [['email' => $this->to]],
                    'htmlContent' => '<html><body>' . str_replace("||", "<br>", $this->html) . '</body></html>'
                ])
            );
    }
}
