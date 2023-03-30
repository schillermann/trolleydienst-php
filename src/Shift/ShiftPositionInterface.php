<?php
namespace App\Shift;

interface ShiftPositionInterface
{
    public function array(): array;

    public function endTime(): \DateTimeInterface;

    public function publisher(int $publisherId): PublisherInterface;
    
    public function publishers(): \Generator;

    public function register(int $publisherId): void;

    public function startTime(): \DateTimeInterface;

    public function withdraw(int $publisherId): void;
}