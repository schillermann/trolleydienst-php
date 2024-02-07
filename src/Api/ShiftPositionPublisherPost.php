<?php

namespace App\Api;

use App\Database\ApplicationsSqlite;
use App\Database\PublishersSqlite;
use App\Database\ShiftsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftPositionPublisherPost implements PageInterface
{
  private ApplicationsSqlite $applicationsStore;
  private ShiftsSqlite $shiftsStore;
  private PublishersSqlite $publishersStore;
  private int $shiftId;
  private int $shiftPositionId;
  private int $publisherId;

  public function __construct(
    ApplicationsSqlite $applicationsStore,
    ShiftsSqlite $shiftsStore,
    PublishersSqlite $publishersStore,
    int $shiftId,
    int $shiftPositionId,
    int $publisherId = 0
  ) {
    $this->applicationsStore = $applicationsStore;
    $this->shiftsStore = $shiftsStore;
    $this->publishersStore = $publishersStore;
    $this->shiftId = $shiftId;
    $this->shiftPositionId = $shiftPositionId;
    $this->publisherId = $publisherId;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    $shift = $this->shiftsStore->shift($this->shiftId);

    if ($shift->id() === 0 || $shift->positions() < $this->shiftPositionId) {
      return $output->withMetadata(
        PageInterface::STATUS,
        'HTTP/1.1 404 Not Found'
      );
    }

    $publisher = $this->publishersStore->publisher($this->publisherId);
    if ($publisher->id() === 0) {
      return $output->withMetadata(
        PageInterface::STATUS,
        'HTTP/1.1 404 Not Found'
      );
    }
    $applications = $this->applicationsStore->applications(
      $this->shiftId,
      $this->shiftPositionId
    );
    foreach ($applications as $application) {
      if ($application->publisherId() === $this->publisherId) {
        return $output->withMetadata(
          PageInterface::STATUS,
          'HTTP/1.1 409 Conflict'
        );
      }
    }
    $this->applicationsStore->add(
      $this->shiftId,
      $this->shiftPositionId,
      $this->publisherId
    );

    return $output->withMetadata(
      PageInterface::STATUS,
      'HTTP/1.1 201 Created'
    );
  }

  public function withMetadata(string $name, string $value): PageInterface
  {
    if ($name !== PageInterface::BODY) {
      return $this;
    }

    $body = json_decode($value, true, 2);
    return new self(
      $this->applicationsStore,
      $this->shiftsStore,
      $this->publishersStore,
      $this->shiftId,
      $this->shiftPositionId,
      $body["publisherId"]
    );
  }
}
