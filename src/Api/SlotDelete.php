<?php

namespace App\Api;

use App\Database\SlotsSqlite;
use App\UserSession;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class SlotDelete implements PageInterface
{
    private UserSession $userSession;
    private SlotsSqlite $slots;
    private int $routeId;
    private int $shiftNumber;
    private int $publisherId;

    public function __construct(
        UserSession $userSession,
        SlotsSqlite $slots,
        int $routeId,
        int $shiftNumber,
        int $publisherId
    ) {
        $this->userSession = $userSession;
        $this->slots = $slots;
        $this->routeId = $routeId;
        $this->shiftNumber = $shiftNumber;
        $this->publisherId = $publisherId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if (
            !$this->userSession->admin() &&
            $this->userSession->publisherId() != $this->publisherId
        ) {
            return $output->withMetadata(
                PageInterface::OUTPUT_STATUS,
                PageInterface::OUTPUT_STATUS_400_BAD_REQUEST
            )->withMetadata(
                PageInterface::METADATA_BODY,
                json_encode(['error' => 'Wrong publisher'])
            );
        }

        $slot = $this->slots->slot(
            $this->routeId,
            $this->shiftNumber,
            $this->publisherId
        );

        if ($slot->routeId() === 0) {
            return $output->withMetadata(
                PageInterface::OUTPUT_STATUS,
                PageInterface::OUTPUT_STATUS_404_NOT_FOUND
            );
        }

        $this->slots->releaseSlot(
            $this->routeId,
            $this->shiftNumber,
            $this->publisherId
        );

        return $output->withMetadata(
            PageInterface::OUTPUT_STATUS,
            PageInterface::OUTPUT_STATUS_204_NO_CONTENT
        );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
