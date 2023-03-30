<?php
namespace App\Shift;

interface ShiftInterface
{
    function array(): array;

    function shiftPosition(int $id): ShiftPositionInterface;

    function shiftPositions(): \Generator;
}