<?php

namespace App\Api;

use App\Database\RoutesSqlite;
use App\UserSession;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class RoutePost implements PageInterface
{
    private UserSession $userSession;
    private RoutesSqlite $routes;
    private string $routeName;
    private \DateTimeImmutable $start;
    private int $numberOfShifts;
    private int $minutesPerShift;
    private string $color;

    public function __construct(
        UserSession $userSession,
        RoutesSqlite $routes,
        string $routeName = "",
        \DateTimeImmutable $start = new \DateTimeImmutable(),
        int $numberOfShifts = 0,
        int $minutesPerShift = 0,
        string $color = ""
    ) {
        $this->userSession = $userSession;
        $this->routes = $routes;
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
                PageInterface::STATUS_403_FORBIDDEN
            )->withMetadata(
                PageInterface::METADATA_BODY,
                json_encode(['error' => 'You need admin permission'])
            );
        }

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
                PageInterface::METADATA_BODY,
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
        if ($name === PageInterface::METADATA_BODY) {
            $body = json_decode($value, true);
            return new self(
                $this->userSession,
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
