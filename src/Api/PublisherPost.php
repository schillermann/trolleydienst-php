<?php

namespace App\Api;

use App\Database\PublishersSqlite;
use App\UserSession;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class PublisherPost implements PageInterface
{
    private UserSession $userSession;
    private PublishersSqlite $publishers;
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

    function __construct(
        UserSession $userSession,
        PublishersSqlite $publishers,
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
        $this->userSession = $userSession;
        $this->publishers = $publishers;
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

    function viaOutput(OutputInterface $output): OutputInterface
    {
        if (!$this->userSession->admin()) {
            return $output->withMetadata(
                PageInterface::STATUS,
                PageInterface::STATUS_401_UNAUTHORIZED
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
            PageInterface::STATUS,
            PageInterface::STATUS_201_CREATED
        )->withMetadata(
            'Content-Type',
            'application/json'
        )
            ->withMetadata(
                PageInterface::BODY,
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

    function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::BODY) {
            $body = json_decode($value, true);
            return new self(
                $this->userSession,
                $this->publishers,
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

    function randomPassword(int $length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }
}
