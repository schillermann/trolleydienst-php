<?php

namespace App\Api;

use App\Config;
use App\Database\CalendarsSqlite;
use App\Database\PublishersSqlite;
use App\Database\RoutesSqlite;
use App\UserSession;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class PutPage implements PageInterface
{
    function __construct(private \PDO $pdo, private UserSession $userSession, private Config $config)
    {
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output->withMetadata(
            PageInterface::STATUS,
            'HTTP/1.1 404 Not Found'
        );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        if ($name !== PageInterface::METADATA_PATH) {
            return $this;
        }

        if (preg_match('|^/api/calendars/([0-9]+)/routes/([0-9]+)$|', $value, $matches) === 1) {
            return new RoutePut(
                $this->userSession,
                new RoutesSqlite($this->pdo, (int)$matches[1]),
                (int)$matches[2]
            );
        }

        if (preg_match('|^/api/calendars/([0-9]+)$|', $value, $matches) === 1) {
            return new CalendarPut(
                $this->userSession,
                new CalendarsSqlite($this->pdo),
                (int)$matches[1]
            );
        }

        if (preg_match('|^/api/publishers/([0-9]+)$|', $value, $matches) === 1) {
            return new PublisherPut(new PublishersSqlite($this->pdo), $this->config, (int)$matches[1]);
        }

        return $this;
    }
}
