<?php

namespace App\Api;

use App\Database\CalendarTypesSqlite;
use PhpPages\Form\SimpleFormData;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class CalendarTypes implements PageInterface
{
    private CalendarTypesSqlite $calendarTypes;
    private int $pageNumber;
    private int $pageItems;

    function __construct(CalendarTypesSqlite $calendarTypes, int $pageNumber = 0, int $pageItems = 50)
    {
        $this->calendarTypes = $calendarTypes;
        $this->pageNumber = $pageNumber;
        $this->pageItems = $pageItems;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $offset = ($this->pageNumber - 1) * $this->pageItems;
        $limit = $this->pageItems;

        $calendarTypes = $this->calendarTypes->all($offset, $limit);
        $body = [];
        foreach ($calendarTypes as $calendarType) {
            $body[] = [
                'id' => $calendarType->id(),
                'name' => $calendarType->name(),
                'publishersPerShift' => $calendarType->publishersPerShift(),
                'info' => $calendarType->info(),
                'updatedOn' => $calendarType->updatedOn()->format(\DateTimeInterface::ATOM),
                'createdOn' => $calendarType->createdOn()->format(\DateTimeInterface::ATOM),
            ];
        }

        return $output
            ->withMetadata(
                'Content-Type',
                'application/json'
            )
            ->withMetadata(
                PageInterface::BODY,
                json_encode(
                    $body,
                    JSON_THROW_ON_ERROR,
                    3
                )
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::QUERY) {
            $query = new SimpleFormData($value);

            return new self(
                $this->calendarTypes,
                (int)$query->paramWithDefault('page-number', '1'),
                (int)$query->paramWithDefault('page-items', '10'),
            );
        }

        return $this;
    }
}
