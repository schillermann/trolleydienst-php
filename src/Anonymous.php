<?php
namespace App;

class Anonymous implements PublisherInterface
{
    const USERNAME = 'anonymous';

    function active(): bool
    {
        return true;
    }

    function administrative(): bool
    {
        return false;
    }

    function adminNote(): string
    {
        return '';
    }

    function createdOn(): \DateTimeInterface
    {
        return new \DateTime();
    }

    function congregation(): string
    {
        return '';
    }

    function email(): string
    {
        return '';
    }

    function firstName(): string
    {
        return '';
    }

    function id(): int
    {
        return 0;
    }

    function language(): string
    {
        return '';
    }

    function lastName(): string
    {
        return '';
    }

    function loggedOn(): \DateTimeInterface
    {
        return new \DateTime();
    }

    function mobile(): string
    {
        return '';
    }

    function phone(): string
    {
        return '';
    }

    function update(
        bool $active,
        bool $administrative,
        string $adminNote,
        string $congregation,
        string $email,
        string $firstName,
        string $language,
        string $lastName,
        string $mobile,
        string $phone,
        string $username,
        string $userNote
    ): void {}

    function updateLoggedOnByNow(): void {}

    function updatedOn(): \DateTimeInterface
    {
        return new \DateTime();
    }

    function username(): string
    {
        return self::USERNAME;
    }
    
    function userNote(): string
    {
        return '';
    }
}