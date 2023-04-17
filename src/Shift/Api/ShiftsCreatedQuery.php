<?php

namespace App\Shift\Api;

use App\Shift\ShiftCalendarInterface;
use PhpPages\Form\SimpleFormData;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftsCreatedQuery implements PageInterface
{
    private ShiftCalendarInterface $shiftCalendar;
    private \DateTimeInterface $dateFrom;
    private int $shiftTypeId;
    private int $pageNumber;
    private int $pageItems;

    public function __construct(
        ShiftCalendarInterface $shiftCalendar,
        \DateTimeInterface $dateFrom = new \DateTimeImmutable('0000-01-01'),
        int $shiftTypeId = 0,
        int $pageNumber = 0,
        int $pageItems = 10
    ) {
        $this->shiftCalendar = $shiftCalendar;
        $this->dateFrom = $dateFrom;
        $this->shiftTypeId = $shiftTypeId;
        $this->pageNumber = $pageNumber;
        $this->pageItems = $pageItems;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $shiftsFrom = $this->shiftCalendar->shiftsFrom(
            $this->dateFrom,
            $this->shiftTypeId,
            $this->pageNumber,
            $this->pageItems
        );

        $shifts = [];

        foreach ($shiftsFrom as $shift) {
            $shifts[] = $shift->array();
        }

        $shiftsTotal = $this->shiftCalendar->shiftCount($this->dateFrom, $this->shiftTypeId);
        $shiftsFrom = (($this->pageNumber - 1) * $this->pageItems) + 1;
        $daysTo = $this->pageNumber * $this->pageItems;
        if ($daysTo > $shiftsTotal) {
            $daysTo = $shiftsTotal;
        }

        return $output
            ->withMetadata(
                'Accept-Ranges',
                'count'
            )
            ->withMetadata(
                'Content-Range',
                "count $shiftsFrom-$daysTo/$shiftsTotal"
            )
            ->withMetadata(
                'Content-Type',
                'application/json'
            )
            ->withMetadata(
                PageInterface::BODY,
                json_encode($shifts)
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::QUERY) {
            $query = new SimpleFormData($value);

            return new self(
                $this->shiftCalendar,
                new \DateTimeImmutable($query->param('start-date')),
                $query->param('shift-type-id'),
                $query->paramWithDefault('page-number', '1'),
                $query->paramWithDefault('page-items', '10'),
            );
        }

        return $this;
    }
}
