<?php

namespace App\Api;

use App\Config;
use App\LoginPage;
use App\ResetPasswordPage;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class UnauthorizedPage implements PageInterface
{
    function __construct(private Config $config)
    {
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output->withMetadata(
            PageInterface::OUTPUT_STATUS,
            PageInterface::OUTPUT_STATUS_401_UNAUTHORIZED
        );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        if (PageInterface::METADATA_PATH === $name) {
            switch ($value) {
                case '/':
                    return new LoginPage($this->config);
                case '/reset-password':
                    return new ResetPasswordPage($this->config);
            }
        }

        return $this;
    }
}
