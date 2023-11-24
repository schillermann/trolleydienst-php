<?php

namespace App\Api;

use App\Database\ShiftsSqlite;
use PhpPages\Form\SimpleFormData;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftsGet implements PageInterface
{
  private ShiftsSqlite $shifts;
  private \DateTimeInterface $dateFrom;
  private int $shiftTypeId;
  private int $pageNumber;
  private int $pageItems;

  public function __construct(
    ShiftsSqlite $shifts,
    \DateTimeInterface $dateFrom = new \DateTimeImmutable('0000-01-01'),
    int $shiftTypeId = 0,
    int $pageNumber = 0,
    int $pageItems = 10
  ) {
    $this->shifts = $shifts;
    $this->dateFrom = $dateFrom;
    $this->shiftTypeId = $shiftTypeId;
    $this->pageNumber = $pageNumber;
    $this->pageItems = $pageItems;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $shifts = $this->shifts->shiftsFrom(
      $this->dateFrom,
      $this->shiftTypeId,
      $this->pageNumber,
      $this->pageItems
    );

    $body = [];

    foreach ($shifts as $shift) {
      $body[] = [
        'id' => $shift->id(),
        'typeId' => $shift->typeId(),
        'routeName' => $shift->routeName(),
        'start' => $shift->start()->format(\DateTimeInterface::ATOM),
        'positions' => $shift->positions(),
        'minutesPerShift' => $shift->minutesPerShift(),
        'colorHex' => $shift->colorHex(),
        'updatedAt' => $shift->updatedAt()->format(\DateTimeInterface::ATOM),
        'createdAt' => $shift->createdAt()->format(\DateTimeInterface::ATOM)
      ];
    }

    $pagesTotalNumber = $this->shifts->shiftsTotalNumber($this->dateFrom, $this->shiftTypeId);
    $itemNumberFrom = (($this->pageNumber - 1) * $this->pageItems) + 1;
    $itemNumberTo = $this->pageNumber * $this->pageItems;
    if ($itemNumberTo > $pagesTotalNumber) {
      $itemNumberTo = $pagesTotalNumber;
    }

    return $output
      ->withMetadata(
        'Accept-Ranges',
        'count'
      )
      ->withMetadata(
        'Content-Range',
        "count $itemNumberFrom -$itemNumberTo/$pagesTotalNumber"
      )
      ->withMetadata(
        'Content-Type',
        'application/json'
      )
      ->withMetadata(
        PageInterface::BODY,
        json_encode($body)
      );
  }

  public function withMetadata(string $name, string $value): PageInterface
  {
    if ($name === PageInterface::QUERY) {
      $query = new SimpleFormData($value);

      return new self(
        $this->shifts,
        new \DateTimeImmutable($query->param('start-date')),
        (int)$query->param('shift-type-id'),
        (int)$query->paramWithDefault('page-number', '1'),
        (int)$query->paramWithDefault('page-items', '10'),
      );
    }

    return $this;
  }
}
