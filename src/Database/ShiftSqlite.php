<?php

namespace App\Database;

class ShiftSqlite
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
  function typeId(): int
  {
    return (int)$this->columns['id_shift_type'];
  }
  function routeName(): string
  {
    return $this->columns['route'];
  }
  function start(): \DateTimeImmutable
  {
    return new \DateTimeImmutable($this->columns['datetime_from']);
  }
  function positions(): int
  {
    return $this->columns['number'];
  }
  function minutesPerShift(): int
  {
    return $this->columns['minutes_per_shift'];
  }
  function colorHex(): string
  {
    return $this->columns['color_hex'];
  }
  function lastModifiedOn(): \DateTimeImmutable
  {
    return new \DateTimeImmutable($this->columns['last_modified_on']);
  }
  function createdOn(): \DateTimeImmutable
  {
    return new \DateTimeImmutable($this->columns['created_on']);
  }
}
