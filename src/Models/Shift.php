<?php
namespace App\Models;

class Shift {

    function __construct(
        int $id_shift,
        int $id_shift_type,
        string $route,
        \DateTime $datetime_from,
        int $number,
        int $minutes_per_shift,
        string $color_hex
    ) {
        $this->id_shift = $id_shift;
        $this->id_shift_type = $id_shift_type;
        $this->route = $route;
        $this->datetime_from = $datetime_from;
        $this->number = $number;
        $this->minutes_per_shift = $minutes_per_shift;
        $this->color_hex = $color_hex;
    }

    function get_id_shift(): int {
        return $this->id_shift;
    }

    function get_id_shift_type(): int {
        return $this->id_shift_type;
    }

    function get_route(): string {
        return $this->route;
    }

    function get_datetime_from(): \DateTime {
        return $this->datetime_from;
    }

    function get_number(): int {
        return $this->number;
    }

    function get_minutes_per_shift(): float {
        return $this->minutes_per_shift;
    }

    function get_color_hex(): string {
        return $this->color_hex;
    }

    protected $id_shift, $id_shift_type, $route, $datetime_from, $number, $minutes_per_shift, $color_hex;
}