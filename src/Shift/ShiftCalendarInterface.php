<?php
namespace App\Shift;

interface ShiftCalendarInterface
{
    public function dayCount(\DateTimeInterface $from, int $shiftTypeId): int;

    public function daysFrom(\DateTimeInterface $from, int $shiftTypeId, int $pageNumber, int $pageItems): \Generator;

    public function day(int $id): ShiftDayInterface;
}