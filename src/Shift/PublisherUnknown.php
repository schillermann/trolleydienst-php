<?php

namespace App\Shift;

class PublisherUnknown implements PublisherInterface
{
    public function array(): array
    {
        return [
            'id' => 0,
            'firstname' => '',
            'lastname' => ''
        ];
    }

    public function id(): int
    {
        return 0;
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
