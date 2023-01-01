<?php
namespace App\Shift\Api;

use App\Shift\ShiftCalendarInterface;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class WithdrawShiftApplicationCommand implements PageInterface
{
    private ShiftCalendarInterface $shiftCalendar;
    private int $shiftDayId;
    private int $shiftId;
    private int $publisherId;

    public function __construct(ShiftCalendarInterface $shiftCalendar, int $shiftDayId = 0, int $shiftId = 0, int $publisherId = 0)
    {
        $this->shiftCalendar = $shiftCalendar;
        $this->shiftDayId = $shiftDayId;
        $this->shiftId = $shiftId;
        $this->publisherId = $publisherId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $shiftDay = $this->shiftCalendar->day($this->shiftDayId);
        $shift = $shiftDay->shift($this->shiftId);
        $shift->withdraw($this->publisherId);

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
                $body['shiftDayId'],
                $body['shiftId'],
                $body['publisherId']
            );
        }

        return $this;
    }
}