<?php

namespace App\Api;

use App\Database\ShiftsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftEndpoint implements PageInterface
{
  private ShiftsSqlite $shifts;
  private int $shiftId;
  private string $method;
  function __construct(ShiftsSqlite $shifts, int $shiftId, string $method = '')
  {
    $this->shifts = $shifts;
    $this->shiftId = $shiftId;
    $this->method = $method;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    if ($this->method !== 'GET') {
      return $output->withMetadata(
        PageInterface::STATUS,
        'HTTP/1.1 405 Method Not Allowed'
      );
    }

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
            'type' => $shift->type(),
            'routeName' => $shift->routeName(),
            'start' => $shift->start()->format(\DateTimeInterface::ATOM),
            'positions' => $shift->positions(),
            'minutesPerShift' => $shift->minutesPerShift(),
            'colorHex' => $shift->colorHex(),
            'updatedAt' => $shift->updatedAt()->format(\DateTimeInterface::ATOM),
            'createdAt' => $shift->createdAt()->format(\DateTimeInterface::ATOM)
          ],
          JSON_THROW_ON_ERROR,
          2
        )
      );
  }

  public function withMetadata(string $name, string $value): PageInterface
  {
    if ($name === PageInterface::METHOD) {
      return new self($this->shifts, $this->shiftId, $value);
    }
    return $this;
  }
}
