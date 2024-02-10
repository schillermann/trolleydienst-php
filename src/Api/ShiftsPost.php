<?php

namespace App\Api;

use App\Database\CalendarShiftsSqlite;
use App\Shift\HexColorCode;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftsPost implements PageInterface
{
    private CalendarShiftsSqlite $calendarShifts;
    private \DateTimeInterface $start;
    private string $routeName = "";
    private int $numberOfShifts = 0;
    private int $minutesPerShift = 0;
    private HexColorCode $hexColorCode;

    public function __construct(
        CalendarShiftsSqlite $calendarShifts,
        \DateTimeInterface $start = new \DateTimeImmutable('0000-01-01'),
        string $routeName = "",
        int $numberOfShifts = 0,
        int $minutesPerShift = 0,
        HexColorCode $hexColorCode = new HexColorCode("#000000")
    ) {
        $this->calendarShifts = $calendarShifts;
        $this->start = $start;
        $this->routeName = $routeName;
        $this->numberOfShifts = $numberOfShifts;
        $this->minutesPerShift = $minutesPerShift;
        $this->hexColorCode = $hexColorCode;
    }
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $this->calendarShifts->add(
            $this->start,
            $this->routeName,
            $this->numberOfShifts,
            $this->minutesPerShift,
            $this->hexColorCode
        );

        return $output->withMetadata(
            PageInterface::STATUS,
            'HTTP/1.1 201 Created'
        );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::BODY) {
            $body = json_decode($value, true, 2);

            return new self(
                $this->calendarShifts,
                new \Datetime($body['startDate']),
                $body['routeName'],
                $body['numberOfShifts'],
                $body['minutesPerShift'],
                new HexColorCode($body['color'])
            );
        }

        return $this;
    }
}
