<?php

namespace App\Api;

use App\Database\RoutesSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class RoutePost implements PageInterface
{
    private RoutesSqlite $routes;
    private string $routeName;
    private \DateTimeImmutable $start;
    private int $numberOfShifts;
    private int $minutesPerShift;
    private string $color;

    public function __construct(
        RoutesSqlite $routes,
        string $routeName = "",
        \DateTimeImmutable $start = new \DateTimeImmutable(),
        int $numberOfShifts = 0,
        int $minutesPerShift = 0,
        string $color = ""
    ) {
        $this->routes = $routes;
        $this->routeName = $routeName;
        $this->start = $start;
        $this->numberOfShifts = $numberOfShifts;
        $this->minutesPerShift = $minutesPerShift;
        $this->color = $color;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $routeId = $this->routes->add(
            $this->start,
            $this->routeName,
            $this->numberOfShifts,
            $this->minutesPerShift,
            $this->color
        );

        $route = $this->routes->route($routeId);

        return $output->withMetadata(
            PageInterface::STATUS,
            PageInterface::STATUS_201_CREATED
        )->withMetadata(
            'Content-Type',
            'application/json'
        )
            ->withMetadata(
                PageInterface::BODY,
                json_encode(
                    [
                        'id' => $route->id(),
                        'calendarId' => $route->calendarId(),
                        'routeName' =>  $route->routeName(),
                        'start' => $route->start()->format('Y-m-d H:i'),
                        'numberOfShifts' => $route->numberOfShifts(),
                        'minutesPerShift' => $route->minutesPerShift(),
                        "color" => $route->color(),
                        'updatedOn' => $route->updatedOn()->format('Y-m-d H:i'),
                        'createdOn' => $route->createdOn()->format('Y-m-d H:i'),
                    ],
                    JSON_THROW_ON_ERROR,
                    2
                )
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::BODY) {
            $body = json_decode($value, true);
            return new self(
                $this->routes,
                $body['routeName'],
                new \DateTimeImmutable($body['start']),
                $body['numberOfShifts'],
                $body['minutesPerShift'],
                $body['color'],
            );
        }

        return $this;
    }
}
