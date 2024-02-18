<?php

namespace App\Api;

use App\Database\CalendarShiftsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class CalendarShiftGet implements PageInterface
{
  private CalendarShiftsSqlite $calendarShifts;
  private int $shiftId;

  function __construct(CalendarShiftsSqlite $calendarShifts, int $shiftId)
  {
    $this->calendarShifts = $calendarShifts;
    $this->shiftId = $shiftId;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $shift = $this->calendarShifts->shift($this->shiftId);

    if ($shift->id() === 0) {
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
            'id' => $shift->id(),
            'routeName' => $shift->routeName(),
            'shiftStart' => $shift->start()->format(\DateTimeInterface::ATOM),
            'numberOfShifts' => $shift->numberOfShifts(),
            'minutesPerShift' => $shift->minutesPerShift(),
            'colorHex' => $shift->colorHex(),
            'lastModifiedOn' => $shift->lastModifiedOn()->format(\DateTimeInterface::ATOM),
            'createdOn' => $shift->createdOn()->format(\DateTimeInterface::ATOM)
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
