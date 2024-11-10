<?php

namespace App\Api;

use App\Database\CalendarsSqlite;
use PhpPages\Form\SimpleFormData;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class CalendarsGet implements PageInterface
{
    private CalendarsSqlite $calendars;
    private int $pageNumber;
    private int $pageItems;

    function __construct(CalendarsSqlite $calendars, int $pageNumber = 0, int $pageItems = 50)
    {
        $this->calendars = $calendars;
        $this->pageNumber = $pageNumber;
        $this->pageItems = $pageItems;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $offset = ($this->pageNumber - 1) * $this->pageItems;
        $limit = $this->pageItems;

        $calendars = $this->calendars->all($offset, $limit);
        $body = [];
        foreach ($calendars as $calendar) {
            $body[] = [
                'id' => $calendar->id(),
                'name' => $calendar->name(),
                'publishersPerShift' => $calendar->publishersPerShift(),
                'info' => $calendar->info(),
                'updatedOn' => $calendar->updatedOn()->format(\DateTimeInterface::ATOM),
                'createdOn' => $calendar->createdOn()->format(\DateTimeInterface::ATOM),
            ];
        }

        return $output
            ->withMetadata(
                'Content-Type',
                'application/json'
            )
            ->withMetadata(
                PageInterface::METADATA_BODY,
                json_encode(
                    $body,
                    JSON_THROW_ON_ERROR,
                    3
                )
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::METADATA_QUERY) {
            $query = new SimpleFormData($value);

            return new self(
                $this->calendars,
                (int)$query->paramWithDefault('page-number', '1'),
                (int)$query->paramWithDefault('page-items', '10'),
            );
        }

        return $this;
    }
}
