<?php

namespace App\Api;

use App\Database\CalendarsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class CalendarGet implements PageInterface
{
    private CalendarsSqlite $calendarsStore;
    private int $calendarId;

    function __construct(CalendarsSqlite $calendarsStore, int $calendarId)
    {
        $this->calendarsStore = $calendarsStore;
        $this->calendarId = $calendarId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $calendar = $this->calendarsStore->calendar($this->calendarId);

        if ($calendar->id() === 0) {
            return $output->withMetadata(
                PageInterface::OUTPUT_STATUS,
                'HTTP/1.1 404 Not Found'
            );
        }

        return $output
          ->withMetadata(
              'Content-Type',
              'application/json'
          )
          ->withMetadata(
              PageInterface::METADATA_BODY,
              json_encode(
                  [
                  'name' => $calendar->name(),
                  'publishersPerShift' => $calendar->publishersPerShift(),
                  'info' => $calendar->info(),
                  'updatedOn' => $calendar->updatedOn()->format(\DateTimeInterface::ATOM),
                  'createdOn' => $calendar->createdOn()->format(\DateTimeInterface::ATOM)
          ],
                  JSON_THROW_ON_ERROR,
                  2
              )
          );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
