<?php

namespace App\Shift;

interface ShiftCalendarInterface
{
    public function add(\DateTimeInterface $start, int $shiftTypeId, string $routeName, int $numberOfShifts, int $minutesPerShift, ColorInterface $color): void;

    public function shiftCount(\DateTimeInterface $from, int $shiftTypeId): int;

    public function shiftsFrom(\DateTimeInterface $from, int $shiftTypeId, int $pageNumber, int $pageItems): \Generator;

    public function shift(int $id, int $shiftTypeId): ShiftInterface;
}
