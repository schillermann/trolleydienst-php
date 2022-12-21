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
        $stmt = $this->pdo->prepare(<<<SQL
            SELECT count(*)
            FROM shifts
            WHERE datetime_from > :from AND id_shift_type = :shiftTypeId
        SQL);
        $stmt->execute([
            'from' => $from->format('Y-m-d'),
            'shiftTypeId' => $shiftTypeId,
        ]);

        return $stmt->fetchColumn();
    }

    public function daysFrom(\DateTimeInterface $from, int $shiftTypeId, int $pageNumber, int $pageItems): \Generator
    {
        $stmtPublisherLimit = $this->pdo->prepare(<<<SQL
            SELECT user_per_shift_max FROM shift_types WHERE id_shift_type = :id
        SQL);
        $stmtPublisherLimit->execute([
            'id' => $shiftTypeId
        ]);
        $publisherLimit = $stmtPublisherLimit->fetchColumn();

        $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift, id_shift_type, route, datetime_from, number, minutes_per_shift, color_hex, updated, created
            FROM shifts
            WHERE datetime_from > :from AND id_shift_type = :shiftTypeId
            ORDER BY datetime_from ASC
            LIMIT :offset, :limit
        SQL);

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
                $publisherLimit,
                $shiftDay['color_hex'],
                new \DateTimeImmutable($shiftDay['updated']),
                new \DateTimeImmutable($shiftDay['created'])
            );
        }
    }

    public function day(int $id): ShiftDayInterface
    {
        $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift, id_shift_type, route, datetime_from, number, minutes_per_shift, color_hex, updated, created
            FROM shifts
            WHERE id_shift = :id
        SQL);

        $stmt->execute([
            'id' => $id
        ]);

        $shiftDay = $stmt->fetch(\PDO::FETCH_ASSOC);

        return new ShiftDay(
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