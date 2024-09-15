<?php

namespace App\Api;

use App\Database\CalendarsSqlite;
use App\UserSession;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class CalendarPost implements PageInterface
{
    private UserSession $userSession;
    private CalendarsSqlite $calendars;
    private string $calendarName;
    private string $info;
    private int $publishersPerShift;

    public function __construct(
        UserSession $userSession,
        CalendarsSqlite $calendars,
        string $calendarName = "",
        string $info = "",
        int $publishersPerShift = 0,
    ) {
        $this->userSession = $userSession;
        $this->calendars = $calendars;
        $this->calendarName = $calendarName;
        $this->info = $info;
        $this->publishersPerShift = $publishersPerShift;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if (!$this->userSession->admin()) {
            return $output->withMetadata(
                PageInterface::STATUS,
                PageInterface::STATUS_401_UNAUTHORIZED
            );
        }

        $calendarId = $this->calendars->add(
            $this->calendarName,
            $this->info,
            $this->publishersPerShift,
        );

        $calendar = $this->calendars->calendar($calendarId);

        return $output->withMetadata(
            PageInterface::STATUS,
            PageInterface::STATUS_201_CREATED
        )->withMetadata(
            'Content-Type',
            'application/json'
        )
            ->withMetadata(
                PageInterface::BODY,
                json_encode(
                    [
                        'id' => $calendar->id(),
                        'name' => $calendar->name(),
                        'publishersPerShift' => $calendar->publishersPerShift(),
                        'info' => $calendar->info(),
                        'updatedOn' => $calendar->updatedOn()->format(\DateTimeInterface::ATOM),
                        'createdOn' => $calendar->createdOn()->format(\DateTimeInterface::ATOM),
                    ],
                    JSON_THROW_ON_ERROR,
                    2
                )
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::BODY) {
            $body = json_decode($value, true);
            return new self(
                $this->userSession,
                $this->calendars,
                $body['name'],
                $body['info'],
                $body['publishersPerShift'],
            );
        }

        return $this;
    }
}
