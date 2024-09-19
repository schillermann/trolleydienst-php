<?php

namespace App\Api;

use App\Database\PublishersSqlite;
use App\UserSession;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class PublisherDelete implements PageInterface
{
    private UserSession $userSession;
    private PublishersSqlite $publishers;
    private bool $demo;
    private int $publisherId;

    public function __construct(
        UserSession $userSession,
        PublishersSqlite $publishers,
        bool $demo,
        int $publisherId
    ) {
        $this->userSession = $userSession;
        $this->publishers = $publishers;
        $this->demo = $demo;
        $this->publisherId = $publisherId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if (!$this->userSession->admin()) {
            return $output->withMetadata(
                PageInterface::STATUS,
                PageInterface::STATUS_403_FORBIDDEN
            )->withMetadata(
                PageInterface::BODY,
                json_encode(['error' => 'You need admin permission'])
            );
        }
        if ($this->demo) {
            return $output->withMetadata(
                PageInterface::STATUS,
                PageInterface::STATUS_403_FORBIDDEN
            )->withMetadata(
                PageInterface::BODY,
                json_encode(['error' => 'Not allowed in the demo version'])
            );
        }

        $deleted = $this->publishers->delete(
            $this->publisherId
        );

        if ($deleted) {
            return $output->withMetadata(
                PageInterface::STATUS,
                PageInterface::STATUS_204_NO_CONTENT
            );
        }

        return $output->withMetadata(
            PageInterface::STATUS,
            PageInterface::STATUS_500_INTERNAL_SERVER_ERROR
        );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
