<?php
namespace App\Shift;

interface PublisherInterface
{
    public function id(): int;

    public function firstname(): string;

    public function lastname(): string;
}