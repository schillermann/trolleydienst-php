<?php

namespace App\Shift;

interface PublishersInterface
{
    public function all(): \Generator;

    public function allActivate(): \Generator;
}
