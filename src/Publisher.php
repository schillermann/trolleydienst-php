<?php
namespace App;

class Publisher implements PublisherInterface
{
    private \PDO $sqlite;
    private int $id;

    function __construct(
        \PDO $sqlite,
        int $id
    ) {
        $this->sqlite = $sqlite;
        $this->id = $id;
    }

    function active(): bool
    {
        return (bool)$this->column('active');
    }

    function administrative(): bool
    {
        return (bool)$this->column('administrative');
    }

    function adminNote(): string
    {
        return $this->column('admin_note');
    }

    function createdOn(): \DateTimeInterface
    {
        return new \DateTimeImmutable(
            $this->column('created_on')
        );
    }

    function congregation(): string
    {
        return $this->column('congregation');
    }

    function email(): string
    {
        return $this->column('email');
    }

    function firstName(): string
    {
        return $this->column('first_name');
    }

    function id(): int
    {
        return $this->id;
    }

    function language(): string
    {
        return $this->column('language');
    }

    function lastName(): string
    {
        return $this->column('last_name');
    }

    function loggedOn(): \DateTimeInterface
    {
        $loggedOn = $this->column('logged_on');
        if (empty($loggedOn)) {
            $loggedOn = '0000-01-01';
        }
        return new \DateTimeImmutable($loggedOn);
    }

    function mobile(): string
    {
        return $this->column('mobile');
    }

    function phone(): string
    {
        return $this->column('phone');
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
    ): void
    {
        $stmt = $this->sqlite->prepare(
            <<<'SQL'
                UPDATE user
                SET
                    active = :active,
                    administrative = :administrative,
                    admin_note = :adminNote,
                    congregation = :congregation,
                    email = :email,
                    first_name = :firstName,
                    language = :language,
                    last_name = :lastName,
                    mobile = :mobile,
                    phone = :phone,
                    username = :username,
                    user_note = :userNote,
                    updated_on = datetime("now", "localtime")
                WHERE id = :id
            SQL
        );

		$stmt->execute([
            'id' => $this->id,
            'active' => $active,
            'administrative' => $administrative,
            'adminNote' => $adminNote,
            'congregation' => $congregation,
            'email' => $email,
            'firstName' => $firstName,
            'language' => $language,
            'lastName' => $lastName,
            'mobile' => $mobile,
            'phone' => $phone,
            'username' => $username,
            'userNote' => $userNote
        ]);
    }

    function updateLoggedOnByNow(): void
    {
        $stmt = $this->sqlite->prepare(
            <<<'SQL'
                UPDATE user SET logged_on = datetime("now", "localtime") WHERE id = :id
            SQL
        );

        $stmt->execute([
            'id' => $this->id
        ]);
    }

    function updatedOn(): \DateTimeInterface
    {
        return new \DateTimeImmutable(
            $this->column('updated_on')
        );
    }

    function username(): string
    {
        return $this->column('username');
    }
    
    function userNote(): string
    {
        return $this->column('user_note');
    }

    private function column(string $name)
    {
        $stmt = $this->sqlite->query(
            <<<'SQL'
                SELECT {$name} FROM user
            SQL
        );

        return $stmt->fetchColumn();
    }
}