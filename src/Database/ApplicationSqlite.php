<?php

namespace App\Database;

class ApplicationSqlite
{
  private int $shiftId;
  private int $publisherId;
  private int $shiftPositionId;
  private array $columns;

  function __construct(int $shiftId, int $publisherId, int $shiftPositionId, array $columns = [])
  {
    $this->shiftId = $shiftId;
    $this->publisherId = $publisherId;
    $this->shiftPositionId = $shiftPositionId;
    $this->columns = $columns;
  }
  function createdAt(): \DateTimeImmutable
  {
    return new \DateTimeImmutable($this->columns['created']);
  }
  function publisherId(): int
  {
    return $this->publisherId;
  }
  function shiftId(): int
  {
    return $this->shiftId;
  }
  function shiftPositionId(): int
  {
    return $this->shiftPositionId;
  }
}
