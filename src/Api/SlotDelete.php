<?php

namespace App\Api;

use App\Database\SlotsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\SessionInterface;

class SlotDelete implements PageInterface
{
    private SessionInterface $session;
    private SlotsSqlite $slots;
    private int $routeId;
    private int $shiftNumber;
    private int $publisherId;

    public function __construct(
        SessionInterface $session,
        SlotsSqlite $slots,
        int $routeId,
        int $shiftNumber,
        int $publisherId
    ) {
        $this->session = $session;
        $this->slots = $slots;
        $this->routeId = $routeId;
        $this->shiftNumber = $shiftNumber;
        $this->publisherId = $publisherId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if (
            !$this->session->param('administrative') &&
            $this->session->param('id_user') != $this->publisherId
        ) {
            return $output->withMetadata(
                PageInterface::STATUS,
                PageInterface::STATUS_401_UNAUTHORIZED
            );
        }

        $slot = $this->slots->slot(
            $this->routeId,
            $this->shiftNumber,
            $this->publisherId
        );

        if ($slot->routeId() === 0) {
            return $output->withMetadata(
                PageInterface::STATUS,
                PageInterface::STATUS_404_NOT_FOUND
            );
        }

        $this->slots->releaseSlot(
            $this->routeId,
            $this->shiftNumber,
            $this->publisherId
        );

        return $output->withMetadata(
            PageInterface::STATUS,
            PageInterface::STATUS_204_NO_CONTENT
        );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
