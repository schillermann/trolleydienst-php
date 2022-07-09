<?php
namespace App\Pages;

use App\UserAnonymous;
use App\UserFormData;
use App\UserPoolInterface;
use PhpPages\Form\SimpleFormData;
use PhpPages\OutputInterface;
use PhpPages\Page\RedirectPage;
use PhpPages\PageInterface;
use PhpPages\SessionInterface;
use PhpPages\TemplateInterface;

class LoginPage implements PageInterface
{
    private TemplateInterface $template;
    private UserPoolInterface $userPool;
    private SessionInterface $session;
    private string $error;

    function __construct(
        TemplateInterface $template,
        UserPoolInterface $userPool,
        SessionInterface $session
    ) {
        $this->template = $template;
        $this->userPool = $userPool;
        $this->session = $session;
        
        $this->error = '';
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output->withMetadata(
                'PhpPages-Body',
                $this->template->content(
                    [ 'error' => $this->error ]
                )
            );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        
        if (!$this->session->empty()) {
            return new RedirectPage('/');
        }

        if ('PhpPages-Body' === $name && !empty($value)) {

            $user = (new UserFormData(
                new SimpleFormData($value),
                $this->userPool
            ))->user();

            if (UserAnonymous::USERNAME === $user->username()) {
                $this->error = 'Email or username is wrong';
            } else {
                
                $this->session->add(
                    'userId',
                    $user->id()
                );
                
                return new RedirectPage('/');
            }
        }

        return $this;
    }
}