<?php

namespace App\Api;

use App\Database\CalendarsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class CalendarPut implements PageInterface
{
    private CalendarsSqlite $calendars;
    private int $calendarId;
    private string $calendarName;
    private string $info;
    private int $publishersPerShift;

    public function __construct(
        CalendarsSqlite $calendars,
        int $calendarId,
        string $calendarName = "",
        string $info = "",
        int $publishersPerShift = 0,
    ) {
        $this->calendars = $calendars;
        $this->calendarId = $calendarId;
        $this->calendarName = $calendarName;
        $this->info = $info;
        $this->publishersPerShift = $publishersPerShift;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $updated = $this->calendars->update(
            $this->calendarId,
            $this->calendarName,
            $this->info,
            $this->publishersPerShift
        );

        if ($updated) {
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
        if ($name === PageInterface::BODY) {
            $body = json_decode($value, true);
            return new self(
                $this->calendars,
                $this->calendarId,
                $body['name'],
                $body['info'],
                $body['publishersPerShift'],
            );
        }

        return $this;
    }
}
