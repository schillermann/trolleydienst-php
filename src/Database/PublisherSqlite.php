<?php

namespace App\Database;

class PublisherSqlite
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
  function username(): string
  {
    return $this->columns['username'];
  }
  function firstname(): string
  {
    return $this->columns['first_name'];
  }
  function lastname(): string
  {
    return $this->columns['last_name'];
  }
  function email(): string
  {
    return $this->columns['email'];
  }
  function phone(): string
  {
    return $this->columns['phone'];
  }
  function mobile(): string
  {
    return $this->columns['mobile'];
  }
  function congregation(): string
  {
    return $this->columns['congregation'];
  }
  function language(): string
  {
    return $this->columns['language'];
  }
  function publisherNote(): string
  {
    if ($this->columns['publisher_note'] === null) {
      return '';
    }
    return $this->columns['publisher_note'];
  }
  function adminNote(): string
  {
    if ($this->columns['admin_note'] === null) {
      return '';
    }
    return $this->columns['admin_note'];
  }
  function active(): bool
  {
    return (bool)$this->columns['active'];
  }
  function administrative(): bool
  {
    return (bool)$this->columns['administrative'];
  }
  function loggedInAt(): \DateTimeImmutable
  {
    return new \DateTimeImmutable($this->columns['logged_on']);
  }
  function updatedAt(): \DateTimeImmutable
  {
    return new \DateTimeImmutable($this->columns['updated_on']);
  }
  function createdAt(): \DateTimeImmutable
  {
    return new \DateTimeImmutable($this->columns['created_on']);
  }
}
