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
    if (array_key_exists('route_id', $this->columns)) {
      return $this->columns['route_id'];
    }
    return 0;
  }

  function publisherId(): int
  {
    if (array_key_exists('publisher_id', $this->columns)) {
      return $this->columns['publisher_id'];
    }
    return 0;
  }

  function shiftNumber(): int
  {
    if (array_key_exists('shift_number', $this->columns)) {
      return $this->columns['shift_number'];
    }
    return 0;
  }

  function firstname(): string
  {
    if (array_key_exists('firstname', $this->columns)) {
      return $this->columns['firstname'];
    }
    return '';
  }

  function lastname(): string
  {
    if (array_key_exists('lastname', $this->columns)) {
      return $this->columns['lastname'];
    }
    return '';
  }

  function createdOn(): \DateTimeImmutable
  {
    if (array_key_exists('created_on', $this->columns)) {
      return new \DateTimeImmutable($this->columns['created_on']);
    }
    return new \DateTimeImmutable();
  }
}
