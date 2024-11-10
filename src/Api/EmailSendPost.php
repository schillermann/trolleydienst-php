<?php

namespace App\Api;

use App\Config;
use PhpPages\OutputInterface;
use PhpPages\Page\Request\ConstraintNotBlank;
use PhpPages\Page\Request\ConstraintType;
use PhpPages\Page\Request\RequestConstraints;
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
    function __construct(
        private Config $config,
        private array $request = []
    ) {
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        $requestConstraints = $this->requestConstraints();
        $requestConstraints->check($this->request);
        if ($requestConstraints->hasErrors()) {
            return $output->withMetadata(
                PageInterface::OUTPUT_STATUS,
                PageInterface::OUTPUT_STATUS_400_BAD_REQUEST
            )->withMetadata(
                PageInterface::METADATA_BODY,
                json_encode(['errors' => $requestConstraints->errors()])
            );
        }

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
            ->to($this->request['to'])
            ->subject($this->request['subject'] ?? '');

        if ($this->request['text']) {
            $email->text($this->request['text']);
        }
        if ($this->request['html']) {
            $email->html($this->request['html']);
        }

        switch ($this->config->emailDispatch()) {
            case 'smtp':
                $transport = new EsmtpTransport($this->config->smtpHost(), $this->config->smtpPort(), $this->config->smtpTls());
                $transport->setUsername($this->config->smtpUsername());
                $transport->setPassword($this->config->smtpPassword());
                break;
            case 'sendinblue':
                $this->sendOverSendinblue($this->request);
                return $output->withMetadata(
                    PageInterface::OUTPUT_STATUS,
                    PageInterface::OUTPUT_STATUS_200_OK
                );
            default:
                $transport = new SendmailTransport();
        }

        $mailer = new Mailer($transport);
        $mailer->send($email);

        return $output->withMetadata(
            PageInterface::OUTPUT_STATUS,
            PageInterface::OUTPUT_STATUS_200_OK
        );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        if (PageInterface::METADATA_BODY === $name) {
            return new self(
                $this->config,
                json_decode($value, true)
            );
        }

        return $this;
    }

    function sendOverSendinblue(array $request): void
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
                    'subject' => $this->request['subject'],
                    'sender' => [
                        'name' => "{$this->config->congregation()} - {$this->config->application()}",
                        'email' => $this->config->emailAddressFrom(),
                    ],
                    'replyTo' => ['name' => $this->config->team(), 'email' => $this->config->emailAddressReply()],
                    'to' => [['email' => $this->request['to']]],
                    'htmlContent' => '<html><body>' . str_replace("||", "<br>", $this->request['html']) . '</body></html>',
                ])
            );
    }

    function requestConstraints(): RequestConstraints
    {
        return (new RequestConstraints())
            ->withPropertyConstraints(
                'to',
                new ConstraintNotBlank(),
                new ConstraintType('string')
            )
            ->withPropertyConstraints(
                'subject',
                new ConstraintType('string')
            )
            ->withPropertyConstraints(
                'text',
                new ConstraintType('string')
            )
            ->withPropertyConstraints(
                'html',
                new ConstraintType('string')
            );
    }
}
