<?php

namespace App\Shift;

class Publishers implements PublishersInterface
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function all(): \Generator
    {
        $stmt = $this->pdo->prepare(<<<SQL
            SELECT id, first_name AS firstname, last_name AS lastname
            FROM publisher
        SQL);

        $stmt->execute();

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $applicant) {
            yield new Publisher(
                $applicant["id"],
                $applicant["first_name"],
                $applicant["last_name"]
            );
        }
    }

    public function allActivate(): \Generator
    {
        $stmt = $this->pdo->prepare(<<<SQL
            SELECT id, first_name AS firstname, last_name AS lastname
            FROM publisher
            WHERE active = true
        SQL);

        $stmt->execute();

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $applicant) {
            yield new Publisher(
                $applicant["id"],
                $applicant["first_name"],
                $applicant["last_name"]
            );
        }
    }
}
