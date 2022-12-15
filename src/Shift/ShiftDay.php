<?php
namespace App\Shift;

class ShiftDay implements ShiftDayInterface
{
    private \PDO $pdo;
    private int $id;
    private int $shiftTypeId;
    private string $routeName;
    private \DateTimeImmutable $startTime;
    private int $numberOfShifts;
    private int $minutesPerShift;
    private string $color;
    private \DateTimeImmutable $updatedAt;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        \PDO $pdo,
        int $id,
        int $shiftTypeId = 0,
        string $routeName = '',
        \DateTimeImmutable $startTime = new \DateTimeImmutable('0000-01-01'),
        int $numberOfShifts = 0,
        int $minutesPerShift = 0,
        string $color = '',
        \DateTimeImmutable $updatedAt = new \DateTimeImmutable('0000-01-01'),
        \DateTimeImmutable $createdAt = new \DateTimeImmutable('0000-01-01')
    )
    {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->shiftTypeId = $shiftTypeId;
        $this->routeName = $routeName;
        $this->startTime = $startTime;
        $this->numberOfShifts = $numberOfShifts;
        $this->minutesPerShift = $minutesPerShift;
        $this->color = $color;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }

    public function array(): array
    {
        return [
            'id' => $this->id,
            'shiftTypeId' => $this->shiftTypeId,
            'routeName' => $this->routeName,
            'startTime' => $this->startTime->format(\DateTime::ATOM),
            'numberOfShifts' => $this->numberOfShifts,
            'minutesPerShift' => $this->minutesPerShift,
            'color' => $this->color,
            'updatedAt' => $this->updatedAt->format(\DateTime::ATOM),
            'createdAt' => $this->createdAt->format(\DateTime::ATOM)
        ];
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