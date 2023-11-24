<?php

namespace App\Database;

class ApplicationSqlite
{
  private int $shiftId;
  private int $publisherId;
  private int $positionId;
  private array $columns;

  function __construct(int $shiftId, int $publisherId, int $positionId, array $columns = [])
  {
    $this->shiftId = $shiftId;
    $this->publisherId = $publisherId;
    $this->positionId = $positionId;
    $this->columns = $columns;
  }
  function shiftId(): int
  {
    return $this->shiftId;
  }
  function publisherId(): int
  {
    return $this->publisherId;
  }
  function positionId(): int
  {
    return $this->positionId;
  }
  function createdAt(): \DateTimeImmutable
  {
    return new \DateTimeImmutable($this->columns['created']);
  }
}
