<?php

namespace App\Shift\Api;

use App\Shift\ShiftCalendarInterface;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class RegisterPublisherForShiftCommand implements PageInterface
{
    private ShiftCalendarInterface $shiftCalendar;
    private int $shiftTypeId;
    private int $shiftId;
    private int $shiftPosition;
    private int $publisherId;

    public function __construct(ShiftCalendarInterface $shiftCalendar, int $shiftTypeId = 0, int $shiftId = 0, int $shiftPosition = 0, int $publisherId = 0)
    {
        $this->shiftCalendar = $shiftCalendar;
        $this->shiftTypeId = $shiftTypeId;
        $this->shiftId = $shiftId;
        $this->shiftPosition = $shiftPosition;
        $this->publisherId = $publisherId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $shift = $this->shiftCalendar->shift($this->shiftId, $this->shiftTypeId);
        $shiftPosition = $shift->shiftPosition($this->shiftPosition);
        $publisher = $shiftPosition->publisher($this->publisherId);
        if ($publisher->id()) {
            return $output->withMetadata(
                PageInterface::STATUS,
                'HTTP/1.1 409 Conflict'
            );
        }

        $shiftPosition->register($this->publisherId);
        $publisher = $shiftPosition->publisher($this->publisherId);

        if (!$publisher->id()) {
            return $output->withMetadata(
                PageInterface::STATUS,
                'HTTP/1.1 422 Unprocessable Entity'
            );
        }

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
                $body['shiftTypeId'],
                $body['shiftId'],
                $body['shiftPositionId'],
                $body['publisherId']
            );
        }

        return $this;
    }
}
