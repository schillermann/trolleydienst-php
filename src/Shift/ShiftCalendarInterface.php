<?php
namespace App\Shift;

interface ShiftCalendarInterface
{
    function add(\DateTimeInterface $start, int $shiftTypeId, string $routeName, int $numberOfShifts, int $minutesPerShift, ColorInterface $color): void;

    function dayCount(\DateTimeInterface $from, int $shiftTypeId): int;

    function daysFrom(\DateTimeInterface $from, int $shiftTypeId, int $pageNumber, int $pageItems): \Generator;

    function day(int $id): ShiftDayInterface;
}