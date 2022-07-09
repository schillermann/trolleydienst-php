<?php
namespace App\Pages;

use PhpPages\OutputInterface;
use PhpPages\Page\RedirectPage;
use PhpPages\PageInterface;
use PhpPages\SessionInterface;

class LogoutPage implements PageInterface
{
    private SessionInterface $session;

    function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
 
    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output;
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        $this->session->clear();
        return new RedirectPage('/login');
    }
}