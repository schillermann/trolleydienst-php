<?php

namespace App\Api;

use App\Database\ShiftTypesSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftTypeGet implements PageInterface
{
  private ShiftTypesSqlite $shiftTypes;
  private int $shiftTypeId;

  function __construct(ShiftTypesSqlite $shiftTypes, int $shiftTypeId)
  {
    $this->shiftTypes = $shiftTypes;
    $this->shiftTypeId = $shiftTypeId;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $shiftType = $this->shiftTypes->shiftType($this->shiftTypeId);

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
            'id' => $shiftType->id(),
            'label' => $shiftType->label(),
            'publisherLimitPerShift' => $shiftType->publisherLimitPerShift(),
            'info' => $shiftType->info(),
            'updatedAt' => $shiftType->updatedAt()->format(\DateTimeInterface::ATOM),
            'createdAt' => $shiftType->createdAt()->format(\DateTimeInterface::ATOM)
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
