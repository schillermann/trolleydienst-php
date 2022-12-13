<?php
namespace App\Shift;

class ShiftCalendar implements ShiftCalendarInterface
{
    private \Pdo $pdo;

    public function __construct(\Pdo $pdo)
    {
        $this->pdo = $pdo;
    }

    public function day(int $id): ShiftDayInterface
    {
        $stmt = $this->pdo->prepare('SELECT id_shift FROM shifts WHERE id_shift = :id');
        $stmt->execute([
            'id' => $id
        ]);

        $day = $stmt->fetch(\PDO::FETCH_ASSOC);

        return new ShiftDay(
            $this->pdo,
            $day['id_shift']
        );
    }
}