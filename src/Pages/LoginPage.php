<?php
namespace App\Pages;

use App\Anonymous;
use App\PublisherFormData;
use App\PublisherPoolInterface;
use PhpPages\Form\SimpleFormData;
use PhpPages\LanguageInterface;
use PhpPages\OutputInterface;
use PhpPages\Page\RedirectPage;
use PhpPages\PageInterface;
use PhpPages\SessionInterface;
use PhpPages\TemplateInterface;

class LoginPage implements PageInterface
{
    private TemplateInterface $template;
    private LanguageInterface $language;
    private PublisherPoolInterface $publisherPool;
    private SessionInterface $session;
    private string $usernameOrEmail;
    private string $error;

    function __construct(
        TemplateInterface $template,
        LanguageInterface $language,
        PublisherPoolInterface $publisherPool,
        SessionInterface $session,
        string $usernameOrEmail = '',
        string $error = ''
    ) {
        $this->template = $template;
        $this->language = $language;
        $this->publisherPool = $publisherPool;
        $this->session = $session;
        $this->usernameOrEmail = $usernameOrEmail;
        $this->error = $error;
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output->withMetadata(
                'PhpPages-Body',
                $this->template
                    ->withParam('language', $this->language)
                    ->withParam('usernameOrEmail', $this->usernameOrEmail)
                    ->withParam('error', $this->error)
                    ->content()
            );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        
        if (!$this->session->empty()) {
            return new RedirectPage('/');
        }

        if ('PhpPages-Body' === $name && !empty($value)) {

            $data = new SimpleFormData($value);

            $publisher = (new PublisherFormData(
                $data,
                $this->publisherPool
            ))->user();

            if ($publisher->username() === Anonymous::USERNAME) {
                return new LoginPage(
                    $this->template,
                    $this->language,
                    $this->publisherPool,
                    $this->session,
                    $data->param('email_or_username'),
                    'Login failed. Please check that the <em>Caps Lock</em> key is not enabled and try again.'
                );
            } else {
                
                $this->session->add(
                    'publisherId',
                    $publisher->id()
                );
                
                return new RedirectPage('/');
            }
        }

        return $this;
    }
}