<?php

namespace App\Api;

use App\Database\ShiftsSqlite;
use App\Shift\HexColorCode; 
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftsPost implements PageInterface
{
    private ShiftsSqlite $shifts;
    private \DateTimeInterface $start;
    private int $shiftTypeId = 0;
    private string $routeName = "";
    private int $numberOfShifts = 0;
    private int $minutesPerShift = 0;
    private HexColorCode $hexColorCode;

    public function __construct(
        ShiftsSqlite $shifts,
        \DateTimeInterface $start = new \DateTimeImmutable('0000-01-01'),
        int $shiftTypeId = 0,
        string $routeName = "",
        int $numberOfShifts = 0,
        int $minutesPerShift = 0,
        HexColorCode $hexColorCode = new HexColorCode("#000000")
    ) {
        $this->shifts = $shifts;
        $this->start = $start;
        $this->shiftTypeId = $shiftTypeId;
        $this->routeName = $routeName;
        $this->numberOfShifts = $numberOfShifts;
        $this->minutesPerShift = $minutesPerShift;
        $this->hexColorCode = $hexColorCode;
    }
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $this->shifts->add(
            $this->start,
            $this->shiftTypeId,
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
                $this->shifts,
                new \Datetime($body['startDate']),
                $body['shiftTypeId'],
                $body['routeName'],
                $body['numberOfShifts'],
                $body['minutesPerShift'],
                new HexColorCode($body['color'])
            );
        }

        return $this;
    }
}
