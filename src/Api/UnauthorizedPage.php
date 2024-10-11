<?php

namespace App\Api;

use App\LoginPage;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class UnauthorizedPage implements PageInterface
{
    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output->withMetadata(
            PageInterface::STATUS,
            PageInterface::STATUS_401_UNAUTHORIZED
        );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        if (PageInterface::PATH === $name && '/' === $value) {
            return new LoginPage();
        }

        return $this;
    }
}
