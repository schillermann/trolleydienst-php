<?php

namespace App\Api;

use App\Database\CalendarsSqlite;
use App\UserSession;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class CalendarDelete implements PageInterface
{
    private UserSession $userSession;
    private CalendarsSqlite $calendars;
    private int $calendarId;

    public function __construct(
        UserSession $userSession,
        CalendarsSqlite $calendars,
        int $calendarId
    ) {
        $this->userSession = $userSession;
        $this->calendars = $calendars;
        $this->calendarId = $calendarId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if (!$this->userSession->admin()) {
            return $output->withMetadata(
                PageInterface::OUTPUT_STATUS,
                PageInterface::OUTPUT_STATUS_403_FORBIDDEN
            )->withMetadata(
                PageInterface::METADATA_BODY,
                json_encode(['error' => 'You need admin permission'])
            );
        }

        $deleted = $this->calendars->delete(
            $this->calendarId
        );

        if ($deleted) {
            return $output->withMetadata(
                PageInterface::OUTPUT_STATUS,
                PageInterface::OUTPUT_STATUS_204_NO_CONTENT
            );
        }

        return $output->withMetadata(
            PageInterface::OUTPUT_STATUS,
            PageInterface::OUTPUT_STATUS_500_INTERNAL_SERVER_ERROR
        );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
