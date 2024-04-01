<?php

namespace App\Api;

use App\Database\ShiftSlotsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftApplicationsGet implements PageInterface
{
    private ShiftSlotsSqlite $shiftSlotsStore;
    private int $routeId;

    function __construct(ShiftSlotsSqlite $shiftSlotsStore, int $routeId)
    {
        $this->shiftSlotsStore = $shiftSlotsStore;
        $this->routeId = $routeId;
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        $body = [];
        foreach ($this->shiftSlotsStore->slots($this->routeId) as $slot) {
            $body[] = [
                'shiftPosition' => $slot->shiftPosition(),
                'publisher' => [
                    'id' => $slot->publisherId(),
                    'firstname' => $slot->firstname(),
                    'lastname' => $slot->lastname()
                ],
                'createdOn' => $slot->createdOn()->format(\DateTimeInterface::ATOM),
            ];
        }

        return $output
            ->withMetadata(
                'Content-Type',
                'application/json'
            )
            ->withMetadata(
                PageInterface::BODY,
                json_encode(
                    $body,
                    JSON_THROW_ON_ERROR,
                    3
                )
            );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
