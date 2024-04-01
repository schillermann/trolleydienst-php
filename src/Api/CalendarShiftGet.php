<?php

namespace App\Api;

use App\Database\CalendarRoutesSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class CalendarShiftGet implements PageInterface
{
  private CalendarRoutesSqlite $calendarRoutes;
  private int $routeId;

  function __construct(CalendarRoutesSqlite $calendarRoutes, int $routeId)
  {
    $this->calendarRoutes = $calendarRoutes;
    $this->routeId = $routeId;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $route = $this->calendarRoutes->route($this->routeId);

    if ($route->id() === 0) {
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
            'id' => $route->id(),
            'routeName' => $route->routeName(),
            'start' => $route->start()->format(\DateTimeInterface::ATOM),
            'numberOfShifts' => $route->numberOfShifts(),
            'minutesPerShift' => $route->minutesPerShift(),
            'color' => $route->color(),
            'updatedOn' => $route->updatedOn()->format(\DateTimeInterface::ATOM),
            'createdOn' => $route->createdOn()->format(\DateTimeInterface::ATOM)
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
