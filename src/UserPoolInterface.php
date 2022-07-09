<?php
namespace App;

interface UserPoolInterface
{
    function all(): \Iterator;

    function user(int $id): UserInterface;

    function userActiveByUsernameOrEmailAndPassword(string $usernameOrEmail, string $password): UserInterface;
}