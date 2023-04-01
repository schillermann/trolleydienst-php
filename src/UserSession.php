<?php
namespace App;

use PhpPages\SessionInterface;

class UserSession implements UserSessionInterface
{
    private SessionInterface $session;
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function json(): string
    {
        return json_encode(
            [
                'id' => (int)$this->session->param('id_user'),
                'name' => $this->session->param('name'),
                'administrative' => (bool)$this->session->param('is_admin')
            ],
            JSON_THROW_ON_ERROR,
            2
        );
    }
} 