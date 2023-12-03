<?php

namespace App\Shift;

class HexColorCode
{
    private string $hex;

    public function __construct(string $hex)
    {
        $this->hex = $hex;
    }

    public function string(): string
    {
        return $this->hex;
    }
}
