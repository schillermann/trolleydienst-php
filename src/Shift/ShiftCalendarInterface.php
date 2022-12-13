<?php
namespace App\Shift;

interface ShiftCalendarInterface
{
    public function day(int $id): ShiftDayInterface;
}