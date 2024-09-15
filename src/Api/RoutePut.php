<?php

namespace App\Api;

use App\Database\RoutesSqlite;
use App\UserSession;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class RoutePut implements PageInterface
{
    private UserSession $userSession;
    private RoutesSqlite $routes;
    private int $routeId;
    private string $routeName;
    private \DateTimeImmutable $start;
    private int $numberOfShifts;
    private int $minutesPerShift;
    private string $color;

    public function __construct(
        UserSession $userSession,
        RoutesSqlite $routes,
        int $routeId,
        string $routeName = "",
        \DateTimeImmutable $start = new \DateTimeImmutable(),
        int $numberOfShifts = 0,
        int $minutesPerShift = 0,
        string $color = ""
    ) {
        $this->userSession = $userSession;
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
        if (!$this->userSession->admin()) {
            return $output->withMetadata(
                PageInterface::STATUS,
                PageInterface::STATUS_401_UNAUTHORIZED
            );
        }

        $updated = $this->routes->update(
            $this->routeId,
            $this->start,
            $this->routeName,
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
                $this->userSession,
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
