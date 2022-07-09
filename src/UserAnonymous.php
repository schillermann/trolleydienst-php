<?php
namespace App;

class UserAnonymous implements UserInterface
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

    function createdAt(): \DateTimeInterface
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

    function id(): int
    {
        return 0;
    }

    function language(): string
    {
        return '';
    }

    function loginAt(): \DateTimeInterface
    {
        return new \DateTime();
    }

    function mobile(): string
    {
        return '';
    }

    function name(): string
    {
        return '';
    }

    function phone(): string
    {
        return '';
    }

    function save(\PDO $sqlite): void {}

    function updatedAt(): \DateTimeInterface
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

    function withActive(bool $enable): UserInterface
    {
        return $this;
    }

    function withAdministrative(bool $enable): UserInterface
    {
        return $this;
    }

    function withEmail(string $email): UserInterface
    {
        return $this;
    }

    function withLoginAt(string $datetime): UserInterface
    {
        return $this;
    }

    function withName(string $name): UserInterface
    {
        return $this;
    }
    
    public function withUsername(string $username): UserInterface
    {
        return $this;
    }
}