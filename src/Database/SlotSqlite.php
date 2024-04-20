<?php

namespace App\Database;

class SlotSqlite
{
  private array $columns;

  function __construct(array $columns = [])
  {
    $this->columns = $columns;
  }

  function routeId(): int
  {
    return $this->columns['route_id'];
  }

  function publisherId(): int
  {
    return $this->columns['publisher_id'];
  }

  function shiftNumber(): int
  {
    return $this->columns['shift_number'];
  }

  function firstname(): string
  {
    return $this->columns['firstname'];
  }

  function lastname(): string
  {
    return $this->columns['lastname'];
  }

  function createdOn(): \DateTimeImmutable
  {
    return new \DateTimeImmutable($this->columns['created_on']);
  }
}
