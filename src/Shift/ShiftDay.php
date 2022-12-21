<?php
namespace App\Shift;

class ShiftDay implements ShiftDayInterface
{
    private \PDO $pdo;
    private int $id;
    private int $shiftTypeId;
    private string $routeName;
    private \DateTimeInterface $startTime;
    private int $numberOfShifts;
    private int $minutesPerShift;
    private int $publisherLimit;
    private string $color;
    private \DateTimeInterface $updatedAt;
    private \DateTimeInterface $createdAt;

    public function __construct(
        \PDO $pdo,
        int $id,
        int $shiftTypeId,
        string $routeName,
        \DateTimeInterface $startTime,
        int $numberOfShifts,
        int $minutesPerShift,
        int $publisherLimit,
        string $color,
        \DateTimeInterface $updatedAt,
        \DateTimeInterface $createdAt
    )
    {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->shiftTypeId = $shiftTypeId;
        $this->routeName = $routeName;
        $this->startTime = $startTime;
        $this->numberOfShifts = $numberOfShifts;
        $this->minutesPerShift = $minutesPerShift;
        $this->publisherLimit = $publisherLimit;
        $this->color = $color;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }

    public function array(): array
    {
        $shifts = [];
        foreach ($this->shifts() as $shift) {
            $shifts[] = $shift->array();
        }

        return [
            'id' => $this->id,
            'shiftTypeId' => $this->shiftTypeId,
            'routeName' => $this->routeName,
            'publisherLimit' => $this->publisherLimit,
            'date' => $this->startTime->format('Y-m-d'),
            'color' => $this->color,
            'updatedAt' => $this->updatedAt->format(\DateTime::ATOM),
            'createdAt' => $this->createdAt->format(\DateTime::ATOM),
            'shifts' => $shifts
        ];
    }

    public function shift(int $shiftId): ShiftInterface
    {
        $startTime = $this->startTime->sub(new \DateInterval('PT' . $this->minutesPerShift * ($shiftId - 1) . 'M'));
        $endTime = $this->startTime->sub(new \DateInterval('PT' . $this->minutesPerShift * $shiftId . 'M'));

        return new Shift(
            $this->pdo,
            $shiftId,
            $this->id,
            $startTime,
            $endTime
        );
    }

    public function shifts(): \Generator
    {
        $startTime = $this->startTime->sub(new \DateInterval('PT' . $this->minutesPerShift . 'M'));
        $endTime = clone $this->startTime;
        
        for ($shiftId = 1; $shiftId <= $this->numberOfShifts; $shiftId++) {

            $startTime = $startTime->add(new \DateInterval('PT' . $this->minutesPerShift . 'M'));
            $endTime = $endTime->add(new \DateInterval('PT' . $this->minutesPerShift . 'M'));

            yield new Shift(
                $this->pdo,
                $shiftId,
                $this->id,
                $startTime,
                $endTime
            );
        }
    }
}