<?php
namespace App\Shift;

class Shift implements ShiftInterface
{
    private \PDO $pdo;
    private int $id;
    private int $shiftDayId;
    private \DateTimeInterface $startTime;
    private \DateTimeInterface $endTime;

    public function __construct(
        \PDO $pdo,
        int $id,
        int $shiftDayId,
        \DateTimeInterface $startTime,
        \DateTimeInterface $endTime
    )
    {
        $this->pdo = $pdo;
        $this->id = $id;   
        $this->shiftDayId = $shiftDayId;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function array(): array
    {
        $publishers = [];
        foreach ($this->publishers() as $publisher) {
            $publishers[] = $publisher->array();
        }

        return [
            'id' => $this->id,
            'from' => $this->startTime->format(\DateTime::ATOM),
            'to' => $this->endTime->format(\DateTime::ATOM),
            'publishers' => $publishers
        ];
    }

    public function endTime(): \DateTimeInterface
    {
        return $this->endTime;
    }

    public function publisher(int $publisherId): PublisherInterface
    {
        $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_user, first_name, last_name
            FROM shift_user_maps
            LEFT JOIN publisher ON shift_user_maps.id_user = publisher.id
            WHERE id_shift = :shiftDayId AND position = :shiftId AND id_user = :publisherId
        SQL);

        $stmt->execute([
            'shiftDayId' => $this->shiftDayId,
            'shiftId' => $this->id,
            'publisherId' => $publisherId
        ]);

        $publisher = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($publisher) {
            return new Publisher(
                $publisher['id_user'],
                $publisher['first_name'],
                $publisher['last_name']
            );
        }

        return new PublisherUnknown();
    }

    public function publishers(): \Generator
    {
        $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_user, first_name, last_name
            FROM shift_user_maps
            LEFT JOIN publisher ON shift_user_maps.id_user = publisher.id
            WHERE id_shift = :shiftDayId AND position = :shiftId
        SQL);

        $stmt->execute([
            'shiftDayId' => $this->shiftDayId,
            'shiftId' => $this->id
        ]);

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $publisher) {
            yield new Publisher(
                $publisher['id_user'],
                $publisher['first_name'],
                $publisher['last_name']
            );
        }
    }

    public function register(int $publisherId): void
    {
        $stmt = $this->pdo->prepare(<<<SQL
            INSERT INTO shift_user_maps (id_shift, position, id_user, created)
            VALUES (:shiftDayId, :shiftId, :publisherId, datetime("now", "localtime"))
        SQL);

        $stmt->execute([
            'shiftDayId' => $this->shiftDayId,
            'shiftId' => $this->id,
            'publisherId' => $publisherId
        ]);
    }

    public function startTime(): \DateTimeInterface
    {
        return $this->startTime;
    }

    public function withdraw(int $publisherId): void
    {
        $stmt = $this->pdo->prepare(<<<SQL
            DELETE FROM shift_user_maps
            WHERE id_shift = :shiftDayId AND position = :shiftId AND id_user = :publisherId
        SQL);

        $stmt->execute([
            'shiftDayId' => $this->shiftDayId,
            'shiftId' => $this->id,
            'publisherId' => $publisherId
        ]);
    }
}