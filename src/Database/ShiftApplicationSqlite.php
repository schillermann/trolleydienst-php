<?php

namespace App\Database;

class ShiftApplicationSqlite
{
    private array $columns;

    function __construct(array $columns = [])
    {
        $this->columns = $columns;
    }

    function shiftId(): int
    {
        return $this->columns['shift_id'];
    }

    function publisherId(): int
    {
        return $this->columns['publisher_id'];
    }

    function shiftPosition(): int
    {
        return $this->columns['shift_position'];
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
