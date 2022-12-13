<?php
namespace App\Shift;

class Publisher implements PublisherInterface
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;        
    }
    public function id(): int
    {
        return $this->id;
    }

    public function firstname(): string
    {
        return '';
    }

    public function lastname(): string
    {
        return '';
    }
}