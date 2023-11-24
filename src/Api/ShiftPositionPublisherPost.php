<?php

namespace App\Api;

use App\Database\ApplicationsSqlite;
use App\Database\PublishersSqlite;
use App\Database\ShiftsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftPositionPublisherPost implements PageInterface
{
  private ApplicationsSqlite $applications;
  private ShiftsSqlite $shifts;
  private PublishersSqlite $publishers;
  private int $shiftId;
  private int $shiftPositionId;
  private int $publisherId;

  public function __construct(ApplicationsSqlite $applications, ShiftsSqlite $shifts, PublishersSqlite $publishers, int $shiftId, int $shiftPositionId, int $publisherId)
  {
    $this->applications = $applications;
    $this->shifts = $shifts;
    $this->publishers = $publishers;
    $this->shiftId = $shiftId;
    $this->shiftPositionId = $shiftPositionId;
    $this->publisherId = $publisherId;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $shift = $this->shifts->shift($this->shiftId);

    if ($shift->id() === 0 || $shift->positions() < $this->shiftPositionId) {
      return $output->withMetadata(
        PageInterface::STATUS,
        'HTTP/1.1 404 Not Found'
      );
    }

    $publisher = $this->publishers->publisher($this->publisherId);
    if ($publisher->id() === 0) {
      return $output->withMetadata(
        PageInterface::STATUS,
        'HTTP/1.1 404 Not Found'
      );
    }

    $this->applications->add($this->shiftId, $this->shiftPositionId, $this->publisherId);

    return $output->withMetadata(
      PageInterface::STATUS,
      'HTTP/1.1 201 Created'
    );
  }

  public function withMetadata(string $name, string $value): PageInterface
  {
    return $this;
  }
}
