<?php

namespace App;

use PhpPages\SessionInterface;

class UserSession
{
    private SessionInterface $session;

    function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    function publisherId(): int
    {
        return (int)$this->session->param('publisher_id');
    }

    function admin(): bool
    {
        return (bool)$this->session->param('admin');
    }

    function active(): bool
    {
        return (bool)$this->session->param('active');
    }
}
