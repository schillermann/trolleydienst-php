<?php

namespace App\Api;

use App\Database\RoutesSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class RouteDelete implements PageInterface
{
    private RoutesSqlite $routes;
    private int $routeId;

    public function __construct(
        RoutesSqlite $routes,
        int $routeId
    ) {
        $this->routes = $routes;
        $this->routeId = $routeId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $deleted = $this->routes->delete(
            $this->routeId
        );

        if ($deleted) {
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
        return $this;
    }
}
