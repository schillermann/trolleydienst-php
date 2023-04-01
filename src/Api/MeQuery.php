<?php
namespace App\Api;

use App\UserSessionInterface;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;
class MeQuery implements PageInterface
{
    private UserSessionInterface $userSession;
    public function __construct(UserSessionInterface $userSession)
    {
        $this->userSession= $userSession;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output
            ->withMetadata(
                'Content-Type',
                'application/json'
            )
            ->withMetadata(
                PageInterface::BODY,
                $this->userSession->json()
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}