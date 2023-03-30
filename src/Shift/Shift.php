<?php
namespace App\Shift;

class Shift implements ShiftInterface
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
        $shiftPositions = [];
        foreach ($this->shiftPositions() as $shiftPosition) {
            $shiftPositions[] = $shiftPosition->array();
        }

        return [
            'id' => $this->id,
            'typeId' => $this->shiftTypeId,
            'routeName' => $this->routeName,
            'publisherLimit' => $this->publisherLimit,
            'date' => $this->startTime->format('Y-m-d'),
            'color' => $this->color,
            'updatedAt' => $this->updatedAt->format(\DateTime::ATOM),
            'createdAt' => $this->createdAt->format(\DateTime::ATOM),
            'positions' => $shiftPositions
        ];
    }

    public function shiftPosition(int $shiftId): ShiftPositionInterface
    {
        $secondsPerShift = $this->minutesPerShift * 60;
        $timestampStartTime = $this->startTime->getTimestamp() + ($secondsPerShift * ($shiftId - 1));
        $timestampEndTime = $this->startTime->getTimestamp() + ($secondsPerShift * $shiftId);

        $startTime = (new \DateTimeImmutable())->setTimestamp($timestampStartTime);
        $endTime = (new \DateTimeImmutable())->setTimestamp($timestampEndTime);

        return new ShiftPosition(
            $this->pdo,
            $shiftId,
            $this->id,
            $startTime,
            $endTime
        );
    }

    public function shiftPositions(): \Generator
    {
        $secondsPerShift = $this->minutesPerShift * 60;
        
        for ($shiftId = 1; $shiftId <= $this->numberOfShifts; $shiftId++) {

            $timestampStartTime = $this->startTime->getTimestamp() + ($secondsPerShift * ($shiftId - 1));
            $timestampEndTime = $this->startTime->getTimestamp() + ($secondsPerShift * $shiftId);
    
            $startTime = (new \DateTimeImmutable())->setTimestamp($timestampStartTime);
            $endTime = (new \DateTimeImmutable())->setTimestamp($timestampEndTime);

            yield new ShiftPosition(
                $this->pdo,
                $shiftId,
                $this->id,
                $startTime,
                $endTime
            );
        }
    }
}