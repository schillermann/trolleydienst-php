<?php

namespace App\Database;

class ShiftTypeSqlite
{
  private int $id;
  private array $columns;

  function __construct(int $id, array $columns = [])
  {
    $this->id = $id;
    $this->columns = $columns;
  }

  function id(): int
  {
    return $this->id;
  }
  function label(): string
  {
    return $this->columns['name'];
  }
  function publisherLimitPerShift(): int
  {
    return $this->columns['user_per_shift_max'];
  }
  function info(): string
  {
    return $this->columns['info'];
  }
  function updatedAt(): \DateTimeImmutable
  {
    return new \DateTimeImmutable($this->columns['updated']);
  }
  function createdAt(): \DateTimeImmutable
  {
    return new \DateTimeImmutable($this->columns['created']);
  }
}