<?php

namespace App\Api;

use App\Database\SlotsSqlite;
use App\Database\PublishersSqlite;
use App\Database\RoutesSqlite;
use App\UserSession;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class SlotsPost implements PageInterface
{
    private UserSession $userSession;
    private SlotsSqlite $slots;
    private RoutesSqlite $routes;
    private PublishersSqlite $publishers;
    private int $routeId;
    private int $shiftNumber;
    private int $publisherId;

    public function __construct(
        UserSession $userSession,
        SlotsSqlite $slots,
        RoutesSqlite $routes,
        PublishersSqlite $publishers,
        int $routeId,
        int $shiftNumber,
        int $publisherId = 0
    ) {
        $this->userSession = $userSession;
        $this->slots = $slots;
        $this->routes = $routes;
        $this->publishers = $publishers;
        $this->routeId = $routeId;
        $this->shiftNumber = $shiftNumber;
        $this->publisherId = $publisherId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if (
            !$this->userSession->admin() &&
            $this->userSession->publisherId() != $this->publisherId
        ) {
            return $output->withMetadata(
                PageInterface::OUTPUT_STATUS,
                PageInterface::OUTPUT_STATUS_403_FORBIDDEN
            );
        }

        $route = $this->routes->route($this->routeId);

        if ($route->id() === 0 || $route->numberOfShifts() < $this->shiftNumber) {
            return $output->withMetadata(
                PageInterface::OUTPUT_STATUS,
                PageInterface::OUTPUT_STATUS_404_NOT_FOUND
            );
        }

        $publisher = $this->publishers->publisher($this->publisherId);
        if ($publisher->id() === 0) {
            return $output->withMetadata(
                PageInterface::OUTPUT_STATUS,
                PageInterface::OUTPUT_STATUS_404_NOT_FOUND
            );
        }
        $slots = $this->slots->slots(
            $this->routeId,
            $this->shiftNumber
        );
        foreach ($slots as $slot) {
            if ($slot->publisherId() === $this->publisherId) {
                return $output->withMetadata(
                    PageInterface::OUTPUT_STATUS,
                    PageInterface::OUTPUT_STATUS_409_CONFLICT
                );
            }
        }
        $this->slots->add(
            $this->routeId,
            $this->shiftNumber,
            $this->publisherId
        );

        return $output->withMetadata(
            PageInterface::OUTPUT_STATUS,
            PageInterface::OUTPUT_STATUS_201_CREATED
        );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name !== PageInterface::METADATA_BODY) {
            return $this;
        }

        $body = json_decode($value, true, 2);
        return new self(
            $this->userSession,
            $this->slots,
            $this->routes,
            $this->publishers,
            $this->routeId,
            $this->shiftNumber,
            $body["publisherId"]
        );
    }
}
