<?php

namespace App\Api;

use App\Database\CalendarRoutesSqlite;
use App\Database\CalendarsSqlite;
use App\Database\ShiftSlotsSqlite;
use PhpPages\Form\SimpleFormData;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class CalendarRoutesGet implements PageInterface
{
  private CalendarsSqlite $calendars;
  private CalendarRoutesSqlite $calendarRoutes;
  private ShiftSlotsSqlite $shiftSlots;
  private int $calendarId;
  private \DateTimeInterface $dateFrom;
  private int $pageNumber;
  private int $pageItems;

  public function __construct(
    CalendarsSqlite $calendars,
    CalendarRoutesSqlite $calendarRoutes,
    ShiftSlotsSqlite $shiftSlots,
    int $calendarId,
    \DateTimeInterface $dateFrom = new \DateTimeImmutable('0000-01-01'),
    int $pageNumber = 0,
    int $pageItems = 10
  ) {
    $this->calendars = $calendars;
    $this->calendarRoutes = $calendarRoutes;
    $this->shiftSlots = $shiftSlots;
    $this->calendarId = $calendarId;
    $this->dateFrom = $dateFrom;
    $this->pageNumber = $pageNumber;
    $this->pageItems = $pageItems;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $routes = $this->calendarRoutes->routesFrom(
      $this->dateFrom,
      $this->pageNumber,
      $this->pageItems
    );

    $body = [];

    $calendar = $this->calendars->calendar($this->calendarId);
    $publisherLimitPerShift = $calendar->publisherLimitPerShift();

    foreach ($routes as $route) {
      $shifts = [];
      $timeFrom = \DateTime::createFromImmutable($route->start());
      for ($shiftIndex = 0; $shiftIndex < $route->numberOfShifts(); $shiftIndex++) {

        $slots = [];

        foreach ($this->shiftSlots->slots($route->id()) as $slot) {
          $slots[] = [
            "publisherId" => $slot->publisherId(),
            "firstname" => $slot->firstname(),
            "lastname" => $slot->lastname(),
          ];
        }

        for ($slotIndex = count($slots); $slotIndex < $publisherLimitPerShift; $slotIndex++) {
          $slots[] = new \stdClass;
        }

        $timeTo = clone $timeFrom;
        $timeTo->modify('+' . $route->minutesPerShift() . ' minutes');
        $shifts[] = [
          "from" => $timeFrom->format('H:i'),
          "to" => $timeTo->format('H:i'),
          "slots" => $slots
        ];
        $timeFrom->modify('+' . $route->minutesPerShift() . ' minutes');
      }


      $body[] = [
        'id' => $route->id(),
        'routeName' => $route->routeName(),
        'start' => $route->start()->format(\DateTimeInterface::ATOM),
        'numberOfShifts' => $route->numberOfShifts(),
        'minutesPerShift' => $route->minutesPerShift(),
        'color' => $route->color(),
        'shifts' => $shifts,
        'updatedOn' => $route->updatedOn()->format(\DateTimeInterface::ATOM),
        'createdOn' => $route->createdOn()->format(\DateTimeInterface::ATOM)
      ];
    }

    $pagesTotalNumber = $this->calendarRoutes->shiftsTotalNumber($this->dateFrom);
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
        $this->calendars,
        $this->calendarRoutes,
        $this->shiftSlots,
        $this->calendarId,
        new \DateTimeImmutable($query->param('start-date')),
        (int)$query->paramWithDefault('page-number', '1'),
        (int)$query->paramWithDefault('page-items', '10'),
      );
    }

    return $this;
  }
}