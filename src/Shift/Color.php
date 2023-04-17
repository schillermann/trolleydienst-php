<?php

namespace App\Shift;

class Color implements ColorInterface
{
    private string $hex;

    public function __construct(string $hex)
    {
        $this->hex = $hex;
    }

    public function __toString(): string
    {
        return $this->hex;
    }
}
