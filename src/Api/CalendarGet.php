<?php

namespace App\Api;

use App\Database\CalendarsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class CalendarGet implements PageInterface
{
  private CalendarsSqlite $calendarsStore;

  function __construct(CalendarsSqlite $calendarsStore)
  {
    $this->calendarsStore = $calendarsStore;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $calendar = $this->calendarsStore->calendar();

    if ($calendar->id() === 0) {
      return $output->withMetadata(
        PageInterface::STATUS,
        'HTTP/1.1 404 Not Found'
      );
    }

    return $output
      ->withMetadata(
        'Content-Type',
        'application/json'
      )
      ->withMetadata(
        PageInterface::BODY,
        json_encode(
          [
            'label' => $calendar->label(),
            'publisherLimitPerShift' => $calendar->publisherLimitPerShift(),
            'info' => $calendar->info(),
            'lastModifiedOn' => $calendar->LastModifiedOn()->format(\DateTimeInterface::ATOM),
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
