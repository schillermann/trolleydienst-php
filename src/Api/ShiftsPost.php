<?php

namespace App\Api;

use App\Shift\Color;
use App\Shift\ColorInterface;
use App\Shift\ShiftCalendarInterface;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftsPost implements PageInterface
{
    private ShiftCalendarInterface $shiftCalendar;
    private \DateTimeInterface $start;
    private int $shiftTypeId = 0;
    private string $routeName = "";
    private int $numberOfShifts = 0;
    private int $minutesPerShift = 0;
    private ColorInterface $color;

    public function __construct(
        ShiftCalendarInterface $shiftCalendar,
        \DateTimeInterface $start = new \DateTimeImmutable('0000-01-01'),
        int $shiftTypeId = 0,
        string $routeName = "",
        int $numberOfShifts = 0,
        int $minutesPerShift = 0,
        ColorInterface $color = new Color("#000000")
    ) {
        $this->shiftCalendar = $shiftCalendar;
        $this->start = $start;
        $this->shiftTypeId = $shiftTypeId;
        $this->routeName = $routeName;
        $this->numberOfShifts = $numberOfShifts;
        $this->minutesPerShift = $minutesPerShift;
        $this->color = $color;
    }
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $this->shiftCalendar->add(
            $this->start,
            $this->shiftTypeId,
            $this->routeName,
            $this->numberOfShifts,
            $this->minutesPerShift,
            $this->color
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
                $this->shiftCalendar,
                new \Datetime($body['startDate']),
                $body['shiftTypeId'],
                $body['routeName'],
                $body['numberOfShifts'],
                $body['minutesPerShift'],
                new Color($body['color'])
            );
        }

        return $this;
    }
}
