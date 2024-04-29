<?php

namespace App\Api;

use App\Database\SlotsSqlite;
use App\Database\PublishersSqlite;
use App\Database\RoutesSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class SlotsPost implements PageInterface
{
  private SlotsSqlite $slots;
  private RoutesSqlite $routes;
  private PublishersSqlite $publishers;
  private int $routeId;
  private int $shiftNumber;
  private int $publisherId;

  public function __construct(
    SlotsSqlite $slots,
    RoutesSqlite $routes,
    PublishersSqlite $publishers,
    int $routeId,
    int $shiftNumber,
    int $publisherId = 0
  ) {
    $this->slots = $slots;
    $this->routes = $routes;
    $this->publishers = $publishers;
    $this->routeId = $routeId;
    $this->shiftNumber = $shiftNumber;
    $this->publisherId = $publisherId;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $route = $this->routes->route($this->routeId);

    if ($route->id() === 0 || $route->numberOfShifts() < $this->shiftNumber) {
      return $output->withMetadata(
        PageInterface::STATUS,
        'HTTP/1.1 404 Not Found'
      );
    }

    $publisher = $this->publishers->publisher($this->publisherId);
    if ($publisher->id() === 0) {
      return $output->withMetadata(
        PageInterface::STATUS,
        'HTTP/1.1 404 Not Found'
      );
    }
    $slots = $this->slots->slots(
      $this->routeId,
      $this->shiftNumber
    );
    foreach ($slots as $slot) {
      if ($slot->publisherId() === $this->publisherId) {
        return $output->withMetadata(
          PageInterface::STATUS,
          'HTTP/1.1 409 Conflict'
        );
      }
    }
    $this->slots->add(
      $this->routeId,
      $this->shiftNumber,
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
      $this->slots,
      $this->routes,
      $this->publishers,
      $this->routeId,
      $this->shiftNumber,
      $body["publisherId"]
    );
  }
}
