<?php

namespace App\Api;

use App\Database\SlotsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class SlotPost implements PageInterface
{
    private SlotsSqlite $slots;
    private int $routeId;
    private int $shiftNumber;
    private int $publisherId;

    public function __construct(
        SlotsSqlite $slots,
        int $routeId,
        int $shiftNumber,
        int $publisherId
    ) {
        $this->slots = $slots;
        $this->routeId = $routeId;
        $this->shiftNumber = $shiftNumber;
        $this->publisherId = $publisherId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $slot = $this->slots->slot($this->routeId, $this->shiftNumber, $this->publisherId);
        if ($slot->routeId() > 0) {
            return $output->withMetadata(
                PageInterface::STATUS,
                'HTTP/1.1 409 Conflict'
            );
        }

        $this->slots->add(
            $this->routeId,
            $this->shiftNumber,
            $this->publisherId
        );

        return $output->withMetadata(
            PageInterface::STATUS,
            'HTTP/1.1 204 No Content'
        );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
