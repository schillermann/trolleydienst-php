<?php
namespace App\Shift;

interface ShiftDayInterface
{
    public function shift(int $id): ShiftInterface;
}