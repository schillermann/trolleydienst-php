<?php

namespace App\Api;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\SessionInterface;

class MeGet implements PageInterface
{
    private SessionInterface $session;
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if ((int)$this->session->param('id_user') === 0) {
            return $output->withMetadata(
                PageInterface::STATUS,
                PageInterface::STATUS_401_UNAUTHORIZED
            );
        }
        return $output
            ->withMetadata(
                'Content-Type',
                'application/json'
            )
            ->withMetadata(
                PageInterface::BODY,
                json_encode(
                    [
                        'id' => (int)$this->session->param('id_user'),
                        'username' => $this->session->param('username'),
                        'firstname' => $this->session->param('firstname'),
                        'lastname' => $this->session->param('lastname'),
                        'email' => $this->session->param('email'),
                        'phone' => $this->session->param('phone'),
                        'mobile' => $this->session->param('mobile'),
                        'congregation' => $this->session->param('congregation'),
                        'language' => $this->session->param('language'),
                        'publisherNote' => $this->session->param('publisher_note'),
                        'adminNote' => $this->session->param('admin_note'),
                        'active' => (bool)$this->session->param('active'),
                        'administrative' => (bool)$this->session->param('administrative'),
                        'loggedOn' => $this->session->param('logged_on'),
                        'updatedOn' => $this->session->param('updated_on'),
                        'createdOn' => $this->session->param('created_on')
                    ],
                    JSON_THROW_ON_ERROR,
                    2
                )
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
