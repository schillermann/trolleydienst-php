<?php

namespace App\Shift;

interface PublisherInterface
{
    public function array(): array;

    public function id(): int;

    public function firstname(): string;

    public function lastname(): string;
}
