<?php

namespace App\Api;

use App\Database\CalendarsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class CalendarGet implements PageInterface
{
  private CalendarsSqlite $calendars;
  private int $shiftTypeId;

  function __construct(CalendarsSqlite $calendars, int $shiftTypeId)
  {
    $this->calendars = $calendars;
    $this->shiftTypeId = $shiftTypeId;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $shiftType = $this->calendars->shiftType($this->shiftTypeId);

    if ($shiftType->id() === 0) {
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
            'label' => $shiftType->label(),
            'publisherLimitPerShift' => $shiftType->publisherLimitPerShift(),
            'info' => $shiftType->info(),
            'lastModifiedOn' => $shiftType->LastModifiedOn()->format(\DateTimeInterface::ATOM),
            'createdOn' => $shiftType->createdOn()->format(\DateTimeInterface::ATOM)
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
