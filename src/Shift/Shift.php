<?php
namespace App\Shift;

class Shift implements ShiftInterface
{
    private \Pdo $pdo;
    private int $shiftDayId;
    private int $shiftId;

    public function __construct(\Pdo $pdo, int $shiftDayId, int $shiftId)
    {
        $this->pdo = $pdo;
        $this->shiftDayId = $shiftDayId;
        $this->shiftId = $shiftId;   
    }

    public function publisher(int $publisherId): PublisherInterface
    {
        $stmt = $this->pdo->prepare('SELECT id_user FROM shift_user_maps WHERE id_shift = :shiftDayId AND position = :shiftId AND id_user = :publisherId');
        $stmt->execute([
            'shiftDayId' => $this->shiftDayId,
            'shiftId' => $this->shiftId,
            'publisherId' => $publisherId
        ]);

        if ($stmt->fetchColumn()) {
            return new Publisher(
                $publisherId
            );
        }

        return new PublisherUnknown();
    }

    public function publishers(): \Generator
    {
        return yield [];
    }

    public function registerPublisher(int $publisherId): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO shift_user_maps (id_shift, position, id_user, created) VALUES (:shiftDayId, :shiftId, :publisherId, datetime("now", "localtime"))');
        $stmt->execute([
            'shiftDayId' => $this->shiftDayId,
            'shiftId' => $this->shiftId,
            'publisherId' => $publisherId
        ]);
    }
}