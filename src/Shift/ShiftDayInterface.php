<?php
namespace App\Shift;

interface ShiftDayInterface
{
    public function array(): array;

    public function shift(int $id): ShiftInterface;
}