<?php
namespace App;

use PhpPages\StorageVeil;

interface PublisherPoolInterface
{
    function all(string $orderBy, string $sort): \Iterator;

    function allByNameOrEmail(string $nameOrEmail, string $orderBy, string $sort): \Generator;

    function publisher(int $id): StorageVeil;

    function publisherActiveByUsernameOrEmailAndPassword(string $usernameOrEmail, string $password): StorageVeil;
}