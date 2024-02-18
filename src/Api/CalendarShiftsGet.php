<?php

namespace App\Api;

use App\Database\CalendarShiftsSqlite;
use PhpPages\Form\SimpleFormData;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class CalendarShiftsGet implements PageInterface
{
  private CalendarShiftsSqlite $calendarShifts;
  private \DateTimeInterface $dateFrom;
  private int $pageNumber;
  private int $pageItems;

  public function __construct(
    CalendarShiftsSqlite $calendarShifts,
    \DateTimeInterface $dateFrom = new \DateTimeImmutable('0000-01-01'),
    int $pageNumber = 0,
    int $pageItems = 10
  ) {
    $this->calendarShifts = $calendarShifts;
    $this->dateFrom = $dateFrom;
    $this->pageNumber = $pageNumber;
    $this->pageItems = $pageItems;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $shifts = $this->calendarShifts->shiftsFrom(
      $this->dateFrom,
      $this->pageNumber,
      $this->pageItems
    );

    $body = [];

    foreach ($shifts as $shift) {
      $body[] = [
        'id' => $shift->id(),
        'routeName' => $shift->routeName(),
        'shiftStart' => $shift->start()->format(\DateTimeInterface::ATOM),
        'shiftPositions' => $shift->numberOfShifts(),
        'minutesPerShift' => $shift->minutesPerShift(),
        'colorHex' => $shift->colorHex(),
        'lastModifiedOn' => $shift->lastModifiedOn()->format(\DateTimeInterface::ATOM),
        'createdOn' => $shift->createdOn()->format(\DateTimeInterface::ATOM)
      ];
    }

    $pagesTotalNumber = $this->calendarShifts->shiftsTotalNumber($this->dateFrom);
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
        $this->calendarShifts,
        new \DateTimeImmutable($query->param('start-date')),
        (int)$query->paramWithDefault('page-number', '1'),
        (int)$query->paramWithDefault('page-items', '10'),
      );
    }

    return $this;
  }
}
