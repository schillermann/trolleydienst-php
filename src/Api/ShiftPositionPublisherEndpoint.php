<?php

namespace App\Api;

use App\Database\ShiftsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftPositionPublisherEndpoint implements PageInterface
{
  private ShiftsSqlite $shifts;
  private int $shiftId;
  private int $shiftPositionId;
  private int $publisherId;
  private string $method;

  public function __construct(ShiftsSqlite $shifts, int $shiftId, int $shiftPositionId, int $publisherId, string $method)
  {
    $this->shifts = $shifts;
    $this->shiftId = $shiftId;
    $this->shiftPositionId = $shiftPositionId;
    $this->publisherId = $publisherId;
    $this->method = $method;
  }

  public function viaOutput(OutputInterface $output): OutputInterface
  {
    if ($this->method !== 'POST') {
      return $output->withMetadata(
        PageInterface::STATUS,
        'HTTP/1.1 405 Method Not Allowed'
      );
    }
    $this->shifts->addPublisher($this->shiftId, $this->shiftPositionId, $this->publisherId);

    return $output->withMetadata(
      PageInterface::STATUS,
      'HTTP/1.1 201 Created'
    );

    //    $shift = $this->shiftCalendar->shift($this->shiftId, $this->shiftTypeId);
    //    $shiftPosition = $shift->shiftPosition($this->shiftPosition);
    //    $publisher = $shiftPosition->publisher($this->publisherId);
    //    if ($publisher->id()) {
    //      return $output->withMetadata(
    //        PageInterface::STATUS,
    //        'HTTP/1.1 409 Conflict'
    //      );
    //    }
    //
    //    $shiftPosition->register($this->publisherId);
    //    $publisher = $shiftPosition->publisher($this->publisherId);
    //
    //    if (!$publisher->id()) {
    //      return $output->withMetadata(
    //        PageInterface::STATUS,
    //        'HTTP/1.1 422 Unprocessable Entity'
    //      );
    //    }
    //
    //    return $output->withMetadata(
    //      PageInterface::STATUS,
    //      'HTTP/1.1 201 Created'
    //    );
  }

  public function withMetadata(string $name, string $value): PageInterface
  {
    if ($name === PageInterface::METHOD) {
      return new self($this->shifts, $this->shiftId, $this->shiftPositionId, $this->publisherId, $value);
    }
    return $this;
  }
}
