<?php

namespace App\Database;

class CalendarSqlite
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
  function name(): string
  {
    return $this->columns['name'];
  }
  function publishersPerShift(): int
  {
    return $this->columns['publishers_per_shift'];
  }
  function info(): string
  {
    return $this->columns['info'];
  }
  function updatedOn(): \DateTimeImmutable
  {
    return new \DateTimeImmutable($this->columns['updated_on']);
  }
  function createdOn(): \DateTimeImmutable
  {
    return new \DateTimeImmutable($this->columns['created_on']);
  }
}
