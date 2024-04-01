<?php

namespace App\Api;

use App\Database\ApplicationsSqlite;
use App\Database\PublishersSqlite;
use App\Database\CalendarRoutesSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftPositionPublisherPost implements PageInterface
{
  private ApplicationsSqlite $applicationsStore;
  private CalendarRoutesSqlite $calendarRoutesStore;
  private PublishersSqlite $publishersStore;
  private int $routeId;
  private int $shiftPositionId;
  private int $publisherId;

  public function __construct(
    ApplicationsSqlite $applicationsStore,
    CalendarRoutesSqlite $calendarRoutesStore,
    PublishersSqlite $publishersStore,
    int $routeId,
    int $shiftPositionId,
    int $publisherId = 0
  ) {
    $this->applicationsStore = $applicationsStore;
    $this->calendarRoutesStore = $calendarRoutesStore;
    $this->publishersStore = $publishersStore;
    $this->routeId = $routeId;
    $this->shiftPositionId = $shiftPositionId;
    $this->publisherId = $publisherId;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $route = $this->calendarRoutesStore->route($this->routeId);

    if ($route->id() === 0 || $route->numberOfShifts() < $this->shiftPositionId) {
      return $output->withMetadata(
        PageInterface::STATUS,
        'HTTP/1.1 404 Not Found'
      );
    }

    $publisher = $this->publishersStore->publisher($this->publisherId);
    if ($publisher->id() === 0) {
      return $output->withMetadata(
        PageInterface::STATUS,
        'HTTP/1.1 404 Not Found'
      );
    }
    $applications = $this->applicationsStore->applications(
      $this->routeId,
      $this->shiftPositionId
    );
    foreach ($applications as $application) {
      if ($application->publisherId() === $this->publisherId) {
        return $output->withMetadata(
          PageInterface::STATUS,
          'HTTP/1.1 409 Conflict'
        );
      }
    }
    $this->applicationsStore->add(
      $this->routeId,
      $this->shiftPositionId,
      $this->publisherId
    );

    return $output->withMetadata(
      PageInterface::STATUS,
      'HTTP/1.1 201 Created'
    );
  }

  public function withMetadata(string $name, string $value): PageInterface
  {
    if ($name !== PageInterface::BODY) {
      return $this;
    }

    $body = json_decode($value, true, 2);
    return new self(
      $this->applicationsStore,
      $this->calendarRoutesStore,
      $this->publishersStore,
      $this->routeId,
      $this->shiftPositionId,
      $body["publisherId"]
    );
  }
}
