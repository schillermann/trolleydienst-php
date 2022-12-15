<?php
namespace App\Shift;

class ShiftCalendar implements ShiftCalendarInterface
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function dayCount(\DateTimeInterface $from, int $shiftTypeId): int
    {
        $stmt = $this->pdo->prepare('SELECT count(*) FROM shifts WHERE datetime_from > :from AND id_shift_type = :shiftTypeId');
        $stmt->execute([
            'from' => $from->format('Y-m-d'),
            'shiftTypeId' => $shiftTypeId,
        ]);

        return $stmt->fetchColumn();
    }

    public function daysFrom(\DateTimeInterface $from, int $shiftTypeId, int $pageNumber, int $pageItems): \Generator
    {
        $stmt = $this->pdo->prepare('SELECT * FROM shifts WHERE datetime_from > :from AND id_shift_type = :shiftTypeId ORDER BY datetime_from ASC LIMIT :offset, :limit');

        $stmt->execute([
            'from' => $from->format('Y-m-d'),
            'shiftTypeId' => $shiftTypeId,
            'offset' => ($pageNumber - 1) * $pageItems,
            'limit' => $pageItems,
        ]);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);

        foreach ($stmt as $shiftDay) {
            yield new ShiftDay(
                $this->pdo,
                $shiftDay['id_shift'],
                $shiftDay['id_shift_type'],
                $shiftDay['route'],
                new \DateTimeImmutable($shiftDay['datetime_from']),
                $shiftDay['number'],
                $shiftDay['minutes_per_shift'],
                $shiftDay['color_hex'],
                new \DateTimeImmutable($shiftDay['updated']),
                new \DateTimeImmutable($shiftDay['created'])
            );
        }
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