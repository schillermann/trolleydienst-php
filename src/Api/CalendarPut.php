<?php

namespace App\Api;

use App\Database\CalendarsSqlite;
use App\UserSession;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class CalendarPut implements PageInterface
{
    private UserSession $userSession;
    private CalendarsSqlite $calendars;
    private int $calendarId;
    private string $calendarName;
    private string $info;
    private int $publishersPerShift;

    public function __construct(
        UserSession $userSession,
        CalendarsSqlite $calendars,
        int $calendarId,
        string $calendarName = "",
        string $info = "",
        int $publishersPerShift = 0,
    ) {
        $this->userSession = $userSession;
        $this->calendars = $calendars;
        $this->calendarId = $calendarId;
        $this->calendarName = $calendarName;
        $this->info = $info;
        $this->publishersPerShift = $publishersPerShift;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if (!$this->userSession->admin()) {
            return $output->withMetadata(
                PageInterface::STATUS,
                PageInterface::STATUS_403_FORBIDDEN
            )->withMetadata(
                PageInterface::BODY,
                json_encode(['error' => 'You need admin permission'])
            );
        }

        $updated = $this->calendars->update(
            $this->calendarId,
            $this->calendarName,
            $this->info,
            $this->publishersPerShift
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
                $this->calendars,
                $this->calendarId,
                $body['name'],
                $body['info'],
                $body['publishersPerShift'],
            );
        }

        return $this;
    }
}
