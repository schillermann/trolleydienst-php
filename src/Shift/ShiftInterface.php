<?php
namespace App\Shift;

interface ShiftInterface
{
    public function publisher(int $publisherId): PublisherInterface;
    
    public function publishers(): \Generator;

    public function registerPublisher(int $publisherId): void;
}