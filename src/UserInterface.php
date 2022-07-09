<?php
namespace App;

interface UserInterface
{
    function active(): bool;

    function administrative(): bool;

    function adminNote(): string;

    function createdAt(): \DateTimeInterface;

    function congregation(): string;

    function email(): string;

    function id(): int;

    function language(): string;

    function loginAt(): \DateTimeInterface;

    function mobile(): string;

    function name(): string;

    function phone(): string;

    function save(\PDO $sqlite): void;

    function updatedAt(): \DateTimeInterface;

    function username(): string;
    
    function userNote(): string;

    function withActive(bool $enable): UserInterface;

    function withAdministrative(bool $enable): UserInterface;

    function withEmail(string $email): UserInterface;

    function withLoginAt(string $datetime): UserInterface;

    function withName(string $name): UserInterface;

    function withUsername(string $username): UserInterface;
}