<?php
namespace App;

use DateTimeImmutable;

class User implements UserInterface
{
    private int $id;
    private array $properties;

    function __construct(
        int $id,
        array $properties = []
    ) {
        $this->id = $id;
        $this->properties = $properties;
    }

    function active(): bool
    {
        return $this->properties['active'];
    }

    function administrative(): bool
    {
        return $this->properties['administrative'];
    }

    function adminNote(): string
    {
        return $this->properties['adminNote'];
    }

    function createdAt(): \DateTimeInterface
    {
        return $this->properties['createdAt'];
    }

    function congregation(): string
    {
        return $this->properties['congregation'];
    }

    function email(): string
    {
        return $this->properties['email'];
    }

    function id(): int
    {
        return $this->id;
    }

    function language(): string
    {
        return $this->properties['language'];
    }

    function loginAt(): \DateTimeInterface
    {
        return $this->properties['loginAt'];
    }

    function mobile(): string
    {
        return $this->properties['mobile'];
    }

    function name(): string
    {
        return $this->properties['name'];
    }

    function phone(): string
    {
        return $this->properties['phone'];
    }

    function save(\PDO $sqlite): void
    {
        $set = '';
        foreach ($this->properties as $name => $value) {
            $set .= $name . ' = \'' .  $value . '\', ';
        }

        $stmt = $sqlite->prepare(
            'UPDATE users SET ' . $set . ' updated = datetime("now", "localtime") WHERE id_user = :id_user'
        );

		$stmt->execute([ ':id_user' => $this->id ]);
    }

    function updatedAt(): \DateTimeInterface
    {
        return $this->properties['updatedAt'];
    }

    function username(): string
    {
        return $this->properties['username'];
    }
    
    function userNote(): string
    {
        return $this->properties['userNote'];
    }

    function withActive(bool $enable): UserInterface
    {
        $this->properties['active'] = $enable;
        return new User(
            $this->id,
            $this->properties
        );
    }

    function withAdministrative(bool $enable): UserInterface
    {
        $this->properties['administrative'] = $enable;
        return new User(
            $this->id,
            $this->properties
        );
    }

    function withEmail(string $email): UserInterface
    {
        $this->properties['email'] = $email;
        return new User(
            $this->id,
            $this->properties
        );
    }

    function withLoginAt(string $datetime): UserInterface
    {
        if (empty($datetime)) {
            $this->properties['loginAt'] = new DateTimeImmutable('0000-01-01');
        } else {
            $this->properties['loginAt'] = new DateTimeImmutable($datetime);
        }
        
        return new User(
            $this->id,
            $this->properties
        );
    }

    function withName(string $name): UserInterface
    {
        $this->properties['name'] = $name;
        return new User(
            $this->id,
            $this->properties
        );
    }

    function withUsername(string $username): UserInterface
    {
        $this->properties['username'] = $username;
        return new User(
            $this->id,$this->properties
        );
    }
}