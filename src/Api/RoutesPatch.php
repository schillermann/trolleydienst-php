<?php

namespace App\Api;

use App\Database\RoutesSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class RoutesPatch implements PageInterface
{
    private RoutesSqlite $routes;
    private int $routeId;
    private string $routeName;
    private \DateTimeImmutable $start;
    private int $numberOfShifts;
    private int $minutesPerShift;
    private string $color;

    public function __construct(
        RoutesSqlite $routes,
        int $routeId,
        string $routeName = "",
        \DateTimeImmutable $start = new \DateTimeImmutable(),
        int $numberOfShifts = 0,
        int $minutesPerShift = 0,
        string $color = ""
    ) {
        $this->routes = $routes;
        $this->routeId = $routeId;
        $this->routeName = $routeName;
        $this->start = $start;
        $this->numberOfShifts = $numberOfShifts;
        $this->minutesPerShift = $minutesPerShift;
        $this->color = $color;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $updated = $this->routes->update(
            $this->routeId,
            $this->routeName,
            $this->start,
            $this->numberOfShifts,
            $this->minutesPerShift,
            $this->color
        );

        if ($updated) {
            return $output->withMetadata(
                PageInterface::STATUS,
                PageInterface::STATUS_204_NO_CONTENT
            );
        }

        return $output->withMetadata(
            PageInterface::STATUS,
            PageInterface::STATUS_500_INTERNAL_SERVER_ERROR
        );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::BODY) {
            $body = json_decode($value, true);
            return new self(
                $this->routes,
                $this->routeId,
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
