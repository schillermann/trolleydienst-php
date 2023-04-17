<?php

namespace App\Shift;

interface ShiftInterface
{
    public function array(): array;

    public function shiftPosition(int $id): ShiftPositionInterface;

    public function shiftPositions(): \Generator;
}
