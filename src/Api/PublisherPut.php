<?php

namespace App\Api;

use App\Config;
use App\Database\PublishersSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class PublisherPut implements PageInterface
{
    public function __construct(
        private PublishersSqlite $publishers,
        private Config $config,
        private int $publisherId,
        private bool $active = false,
        private bool $admin = false,
        private string $firstname = '',
        private string $lastname = '',
        private string $username = '',
        private string $email = '',
        private string $mobile = '',
        private string $phone = '',
        private string $congregation = '',
        private string $languages = '',
        private string $publisherNote = '',
        private string $adminNote = ''
    ) {
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if ($this->config->demo()) {
            return $output->withMetadata(
                PageInterface::OUTPUT_STATUS,
                PageInterface::OUTPUT_STATUS_403_FORBIDDEN
            )->withMetadata(
                PageInterface::METADATA_BODY,
                json_encode(['error' => 'Not allowed in the demo version'])
            );
        }

        $updated = $this->publishers->update(
            $this->publisherId,
            $this->active,
            $this->admin,
            $this->firstname,
            $this->lastname,
            $this->username,
            $this->email,
            $this->mobile,
            $this->phone,
            $this->congregation,
            $this->languages,
            $this->publisherNote,
            $this->adminNote
        );

        if ($updated) {
            return $output->withMetadata(
                PageInterface::OUTPUT_STATUS,
                PageInterface::OUTPUT_STATUS_204_NO_CONTENT
            );
        }

        return $output->withMetadata(
            PageInterface::OUTPUT_STATUS,
            PageInterface::OUTPUT_STATUS_500_INTERNAL_SERVER_ERROR
        );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::METADATA_BODY) {
            $body = json_decode($value, true);
            return new self(
                $this->publishers,
                $this->config,
                $this->publisherId,
                $body['active'],
                $body['admin'],
                $body['firstname'],
                $body['lastname'],
                $body['username'],
                $body['email'],
                $body['mobile'],
                $body['phone'],
                $body['congregation'],
                $body['languages'],
                $body['publisherNote'],
                $body['adminNote'],
            );
        }

        return $this;
    }
}
