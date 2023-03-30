<?php
namespace App\Shift;

class ShiftCalendar implements ShiftCalendarInterface
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    function add(\DateTimeInterface $start, int $shiftTypeId, string $routeName, int $numberOfShifts, int $minutesPerShift, ColorInterface $color): void
    {
        $stmt = $this->pdo->prepare(<<<SQL
            INSERT INTO shifts (id_shift_type, route, datetime_from, number, minutes_per_shift, color_hex, updated, created)
            VALUES (:shiftTypeId, :routeName, :start, :numberOfShifts, :minutesPerShift, :color, datetime("now", "localtime"), datetime("now", "localtime"))
        SQL);

        $stmt->execute([
            'shiftTypeId' => $shiftTypeId,
            'routeName' =>  $routeName,
            'start' => $start->format('Y-m-d H:i'),
            'numberOfShifts' => $numberOfShifts,
            'minutesPerShift' => $minutesPerShift,
            "color" => $color->__toString()
        ]);
    }

    public function shiftCount(\DateTimeInterface $from, int $shiftTypeId): int
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

    public function shiftsFrom(\DateTimeInterface $from, int $shiftTypeId, int $pageNumber, int $pageItems): \Generator
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

        foreach ($stmt as $shift) {
            yield new Shift(
                $this->pdo,
                $shift['id_shift'],
                $shift['id_shift_type'],
                $shift['route'],
                new \DateTimeImmutable($shift['datetime_from']),
                $shift['number'],
                $shift['minutes_per_shift'],
                $publisherLimit,
                $shift['color_hex'],
                new \DateTimeImmutable($shift['updated']),
                new \DateTimeImmutable($shift['created'])
            );
        }
    }

    public function shift(int $id, int $shiftTypeId): ShiftInterface
    {
        $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift, id_shift_type, route, datetime_from, number, minutes_per_shift, color_hex, updated, created
            FROM shifts
            WHERE id_shift_type = :shiftTypeId AND id_shift = :shiftId
        SQL);

        $stmt->execute([
            'shiftTypeId' => $shiftTypeId,
            'shiftId' => $id
        ]);

        $shift = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($shift === false) {
            return new Shift(
                $this->pdo,
                0,
                0,
                "",
                new \DateTimeImmutable(),
                0,
                0,
                0,
                "",
                new \DateTimeImmutable(),
                new \DateTimeImmutable()
            );
        }
        
        $stmtPublisherLimit = $this->pdo->prepare(<<<SQL
            SELECT user_per_shift_max FROM shift_types WHERE id_shift_type = :shiftTypeId
        SQL);
        $stmtPublisherLimit->execute([
            'shiftTypeId' => $shift['id_shift_type']
        ]);
        $publisherLimit = $stmtPublisherLimit->fetchColumn();

        return new Shift(
            $this->pdo,
            $shift['id_shift'],
            $shift['id_shift_type'],
            $shift['route'],
            new \DateTimeImmutable($shift['datetime_from']),
            $shift['number'],
            $shift['minutes_per_shift'],
            $publisherLimit,
            $shift['color_hex'],
            new \DateTimeImmutable($shift['updated']),
            new \DateTimeImmutable($shift['created'])
        );
    }
}