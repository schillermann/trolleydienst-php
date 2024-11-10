<?php

namespace App\Api;

use App\Config;
use App\Database\PublishersSqlite;
use App\UserSession;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class PublisherPost implements PageInterface
{
    public function __construct(
        private UserSession $userSession,
        private PublishersSqlite $publishers,
        private Config $config,
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
        if (!$this->userSession->admin()) {
            return $output->withMetadata(
                PageInterface::OUTPUT_STATUS,
                PageInterface::OUTPUT_STATUS_403_FORBIDDEN
            )->withMetadata(
                PageInterface::METADATA_BODY,
                json_encode(['error' => 'You need admin permission'])
            );
        }
        if ($this->config->demo()) {
            return $output->withMetadata(
                PageInterface::OUTPUT_STATUS,
                PageInterface::OUTPUT_STATUS_403_FORBIDDEN
            )->withMetadata(
                PageInterface::METADATA_BODY,
                json_encode(['error' => 'Not allowed in the demo version'])
            );
        }

        $publisherId = $this->publishers->add(
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
            $this->adminNote,
            $this->randomPassword(8)
        );

        $publisher = $this->publishers->publisher($publisherId);

        return $output->withMetadata(
            PageInterface::OUTPUT_STATUS,
            PageInterface::OUTPUT_STATUS_201_CREATED
        )->withMetadata(
            'Content-Type',
            'application/json'
        )
            ->withMetadata(
                PageInterface::METADATA_BODY,
                json_encode(
                    [
                        'id' => $publisher->id(),
                        'username' => $publisher->username(),
                        'firstname' => $publisher->firstname(),
                        'lastname' => $publisher->lastname(),
                        'email' => $publisher->email(),
                        'phone' => $publisher->phone(),
                        'mobile' => $publisher->mobile(),
                        'congregation' => $publisher->congregation(),
                        'languages' => $publisher->languages(),
                        'publisherNote' => $publisher->publisherNote(),
                        'adminNote' => $publisher->adminNote(),
                        'publisherNote' => $publisher->publisherNote(),
                        'active' => $publisher->active(),
                        'admin' => $publisher->admin(),
                        'updatedOn' => $publisher->updatedOn()->format(\DateTimeInterface::ATOM),
                        'createdOn' => $publisher->createdOn()->format(\DateTimeInterface::ATOM)
                    ],
                    JSON_THROW_ON_ERROR,
                    2
                )
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::METADATA_BODY) {
            $body = json_decode($value, true);
            return new self(
                $this->userSession,
                $this->publishers,
                $this->config,
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

    public function randomPassword(int $length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }
}
