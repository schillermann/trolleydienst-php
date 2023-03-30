<?php
namespace App\Shift;

interface ShiftCalendarInterface
{
    function add(\DateTimeInterface $start, int $shiftTypeId, string $routeName, int $numberOfShifts, int $minutesPerShift, ColorInterface $color): void;

    function shiftCount(\DateTimeInterface $from, int $shiftTypeId): int;

    function shiftsFrom(\DateTimeInterface $from, int $shiftTypeId, int $pageNumber, int $pageItems): \Generator;

    function shift(int $id, int $shiftTypeId): ShiftInterface;
}