<?php

namespace App\Api;

use App\Database\ApplicationsSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ApplicationDelete implements PageInterface
{
    private ApplicationsSqlite $applicationsStore;
    private int $shiftId;
    private int $shiftPositionId;
    private int $publisherId;

    public function __construct(
        ApplicationsSqlite $applicationsStore,
        int $shiftId,
        int $shiftPositionId,
        int $publisherId
    ) {
        $this->applicationsStore = $applicationsStore;
        $this->shiftId = $shiftId;
        $this->shiftPositionId = $shiftPositionId;
        $this->publisherId = $publisherId;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $this->applicationsStore->remove(
            $this->shiftId,
            $this->shiftPositionId,
            $this->publisherId
        );

        return $output->withMetadata(
            PageInterface::STATUS,
            'HTTP/1.1 204 No Content'
        );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}
