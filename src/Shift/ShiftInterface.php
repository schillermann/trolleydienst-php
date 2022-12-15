<?php
namespace App\Shift;

interface ShiftInterface
{
    public function array(): array;

    public function endTime(): \DateTimeInterface;

    public function publisher(int $publisherId): PublisherInterface;
    
    public function publishers(): \Generator;

    public function registerPublisher(int $publisherId): void;

    public function startTime(): \DateTimeInterface;
}