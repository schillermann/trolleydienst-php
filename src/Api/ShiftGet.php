<?php

namespace App\Api;

use App\Database\ShiftsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftGet implements PageInterface
{
  private ShiftsSqlite $shifts;
  private int $shiftId;

  function __construct(ShiftsSqlite $shifts, int $shiftId)
  {
    $this->shifts = $shifts;
    $this->shiftId = $shiftId;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $shift = $this->shifts->shift($this->shiftId);

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
            'typeId' => $shift->typeId(),
            'routeName' => $shift->routeName(),
            'start' => $shift->start()->format(\DateTimeInterface::ATOM),
            'positions' => $shift->positions(),
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
