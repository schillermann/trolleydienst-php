<?php
namespace App\Pages;

use App\UserPoolInterface;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\TemplateInterface;

class UserListPage implements PageInterface
{
    private TemplateInterface $template;
    private UserPoolInterface $userPool;

    function __construct(TemplateInterface $template, UserPoolInterface $userPool)
    {
        $this->template = $template;
        $this->userPool = $userPool;
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output
            ->withMetadata(
                'PhpPages-Body',
                $this->template->content(
                    [ 'userPool' => $this->userPool ]
                )
            );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}