<?php

namespace App\Api;

use App\Database\CalendarsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class CalendarDelete implements PageInterface
{
    private CalendarsSqlite $calendars;
    private int $calendarId;

    public function __construct(
        CalendarsSqlite $calendars,
        int $calendarId
    ) {
        $this->calendars = $calendars;
        $this->calendarId = $calendarId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $deleted = $this->calendars->delete(
            $this->calendarId
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
