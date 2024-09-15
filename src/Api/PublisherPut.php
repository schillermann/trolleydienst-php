<?php

namespace App\Api;

use App\Database\PublishersSqlite;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class PublisherPut implements PageInterface
{
    private PublishersSqlite $publishers;
    private int $publisherId;
    private bool $active;
    private bool $admin;
    private string $firstname;
    private string $lastname;
    private string $username;
    private string $email;
    private string $mobile;
    private string $phone;
    private string $congregation;
    private string $languages;
    private string $publisherNote;
    private string $adminNote;

    public function __construct(
        PublishersSqlite $publishers,
        int $publisherId,
        bool $active = false,
        bool $admin = false,
        string $firstname = '',
        string $lastname = '',
        string $username = '',
        string $email = '',
        string $mobile = '',
        string $phone = '',
        string $congregation = '',
        string $languages = '',
        string $publisherNote = '',
        string $adminNote = ''
    ) {
        $this->publishers = $publishers;
        $this->publisherId = $publisherId;
        $this->active = $active;
        $this->admin = $admin;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->username = $username;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->phone = $phone;
        $this->congregation = $congregation;
        $this->languages = $languages;
        $this->publisherNote = $publisherNote;
        $this->adminNote = $adminNote;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
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
                PageInterface::STATUS,
                PageInterface::STATUS_204_NO_CONTENT
            );
        }

        return $output->withMetadata(
            PageInterface::STATUS,
            PageInterface::STATUS_500_INTERNAL_SERVER_ERROR
        );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::BODY) {
            $body = json_decode($value, true);
            return new self(
                $this->publishers,
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
