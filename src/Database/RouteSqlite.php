<?php

namespace App\Database;

class RouteSqlite
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
  function calendarId(): int
  {
    return (int)$this->columns['calendar_id'];
  }
  function routeName(): string
  {
    return $this->columns['route'];
  }
  function start(): \DateTimeImmutable
  {
    return new \DateTimeImmutable($this->columns['datetime_from']);
  }
  function numberOfShifts(): int
  {
    return (int)$this->columns['number_of_shifts'];
  }
  function minutesPerShift(): int
  {
    return (int)$this->columns['minutes_per_shift'];
  }
  function color(): string
  {
    return $this->columns['color'];
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
