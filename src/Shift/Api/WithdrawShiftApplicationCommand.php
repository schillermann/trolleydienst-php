<?php
namespace App\Shift\Api;

use App\Shift\ShiftCalendarInterface;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class WithdrawShiftApplicationCommand implements PageInterface
{
    private ShiftCalendarInterface $shiftCalendar;
    private int $shiftTypeId;
    private int $shiftId;
    private int $shiftPositionId;
    private int $publisherId;

    public function __construct(ShiftCalendarInterface $shiftCalendar, int $shiftTypeId = 0, int $shiftId = 0, int $shiftPositionId = 0, int $publisherId = 0)
    {
        $this->shiftCalendar = $shiftCalendar;
        $this->shiftTypeId = $shiftTypeId;
        $this->shiftId = $shiftId;
        $this->shiftPositionId = $shiftPositionId;
        $this->publisherId = $publisherId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $shift = $this->shiftCalendar->shift($this->shiftId, $this->shiftTypeId);
        $shiftPosition = $shift->shiftPosition($this->shiftPositionId);
        $shiftPosition->withdraw($this->publisherId);

        return $output->withMetadata(
            PageInterface::STATUS,
            'HTTP/1.1 204 No Content'
        );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::BODY) {
            $body = json_decode($value, true, 2);

            return new self(
                $this->shiftCalendar,
                $body['shiftId'],
                $body['shiftPositionId'],
                $body['publisherId']
            );
        }

        return $this;
    }
}