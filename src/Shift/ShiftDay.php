<?php
namespace App\Shift;

class ShiftDay implements ShiftDayInterface
{
    private \Pdo $pdo;
    private int $id;

    public function __construct(\Pdo $pdo, int $id)
    {
        $this->pdo = $pdo;
        $this->id = $id;        
    }

    public function shift(int $shiftId): ShiftInterface
    {
        return new Shift(
            $this->pdo,
            $this->id,
            $shiftId
        );
    }
}