<?php

namespace App\Api;

use App\Database\RoutesSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class RouteGet implements PageInterface
{
    private RoutesSqlite $routes;
    private int $routeId;

    function __construct(RoutesSqlite $routes, int $routeId)
    {
        $this->routes = $routes;
        $this->routeId = $routeId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $route = $this->routes->route($this->routeId);

        if ($route->id() === 0) {
            return $output->withMetadata(
                PageInterface::OUTPUT_STATUS,
                'HTTP/1.1 404 Not Found'
            );
        }

        return $output
          ->withMetadata(
              'Content-Type',
              'application/json'
          )
          ->withMetadata(
              PageInterface::METADATA_BODY,
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
