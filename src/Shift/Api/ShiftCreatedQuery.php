<?php
namespace App\Shift\Api;

use App\Shift\ShiftCalendar;
use PhpPages\Form\SimpleFormData;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftCreatedQuery implements PageInterface
{
    private \PDO $pdo;
    private int $shiftTypeId;
    private int $shiftId;

    public function __construct(\PDO $pdo, int $shiftTypeId = 0, int $shiftId = 0)
    {
        $this->pdo = $pdo;
        $this->shiftTypeId = $shiftTypeId;
        $this->shiftId = $shiftId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output
            ->withMetadata(
                'Content-Type',
                'application/json'
            )
            ->withMetadata(
                PageInterface::BODY,
                json_encode(
                    (new ShiftCalendar($this->pdo))->shift($this->shiftId, $this->shiftTypeId)->array(),
                    JSON_THROW_ON_ERROR,
                    5
                )
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name != PageInterface::QUERY) {
            return $this;
        }

        $form = new SimpleFormData($value);

        return new self(
            $this->pdo,
            $form->param("shift-type-id"),
            $form->param("shift-id")
        );
    }
}