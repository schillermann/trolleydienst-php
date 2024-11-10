<?php

namespace App\Api;

use App\Config;
use App\Database\CalendarsSqlite;
use App\Database\PublishersSqlite;
use App\Database\RoutesSqlite;
use App\Database\SlotsSqlite;
use App\UserSession;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class DeletePage implements PageInterface
{
    function __construct(private \PDO $pdo, private UserSession $userSession, private Config $config)
    {
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output->withMetadata(
            PageInterface::OUTPUT_STATUS,
            'HTTP/1.1 404 Not Found'
        );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        if ($name !== PageInterface::METADATA_PATH) {
            return $this;
        }

        if (preg_match('|^/api/calendars/([0-9]+)/routes/([0-9]+)/shifts/([0-9]+)/publishers/([0-9]+)$|', $value, $matches) === 1) {
            return new SlotDelete(
                $this->userSession,
                new SlotsSqlite($this->pdo),
                (int)$matches[2],
                (int)$matches[3],
                (int)$matches[4]
            );
        }
        if (preg_match('|^/api/calendars/([0-9]+)/routes/([0-9]+)$|', $value, $matches) === 1) {
            return new RouteDelete(
                $this->userSession,
                new RoutesSqlite($this->pdo, (int)$matches[1]),
                (int)$matches[2]
            );
        }

        if (preg_match('|^/api/calendars/([0-9]+)$|', $value, $matches) === 1) {
            return new CalendarDelete(
                $this->userSession,
                new CalendarsSqlite($this->pdo),
                (int)$matches[1]
            );
        }

        if (preg_match('|^/api/publishers/([0-9]+)$|', $value, $matches) === 1) {
            return new PublisherDelete(
                $this->userSession,
                new PublishersSqlite($this->pdo),
                $this->config,
                (int)$matches[1]
            );
        }

        return $this;
    }
}
