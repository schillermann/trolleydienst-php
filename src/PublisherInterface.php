<?php
namespace App;

interface PublisherInterface
{
    function active(): bool;

    function administrative(): bool;

    function adminNote(): string;

    function createdOn(): \DateTimeInterface;

    function congregation(): string;

    function email(): string;

    function firstName(): string;

    function id(): int;

    function language(): string;

    function lastName(): string;

    function loggedOn(): \DateTimeInterface;

    function mobile(): string;

    function phone(): string;

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
    ): void;

    function updateLoggedOnByNow(): void;

    function updatedOn(): \DateTimeInterface;

    function username(): string;
}