<?php

namespace App\Api;

use App\Database\RoutesSqlite;
use App\UserSession;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class RouteDelete implements PageInterface
{
    private UserSession $userSession;
    private RoutesSqlite $routes;
    private int $routeId;

    public function __construct(
        UserSession $userSession,
        RoutesSqlite $routes,
        int $routeId
    ) {
        $this->userSession = $userSession;
        $this->routes = $routes;
        $this->routeId = $routeId;
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
