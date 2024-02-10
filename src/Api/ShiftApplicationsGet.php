<?php

namespace App\Api;

use App\Database\ShiftApplicationsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftApplicationsGet implements PageInterface
{
    private ShiftApplicationsSqlite $shiftApplicationsStore;

    function __construct(ShiftApplicationsSqlite $shiftApplicationsStore)
    {
        $this->shiftApplicationsStore = $shiftApplicationsStore;
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        $body = [];
        foreach ($this->shiftApplicationsStore->slots() as $slot) {
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
