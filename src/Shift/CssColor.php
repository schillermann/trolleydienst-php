<?php

namespace App\Shift;

class CssColor
{
    private string $hex;

    function __construct(string $hex)
    {
        $this->hex = $hex;
    }

    function string(): string
    {
        return $this->hex;
    }
}
