<?php
namespace App\Shift\Api;

use App\Shift\ShiftCalendarInterface;
use PhpPages\Form\SimpleFormData;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class ShiftDaysListedQuery implements PageInterface
{
    private ShiftCalendarInterface $shiftCalendar;
    private \DateTimeInterface $startTime;
    private int $shiftTypeId;
    private int $pageNumber;
    private int $pageItems;

    public function __construct(
        ShiftCalendarInterface $shiftCalendar,
        \DateTimeInterface $startTime = new \DateTimeImmutable('0000-01-01'),
        int $shiftTypeId = 0,
        int $pageNumber = 0,
        int $pageItems = 10
    )
    {
        $this->shiftCalendar = $shiftCalendar;
        $this->startTime = $startTime;
        $this->shiftTypeId = $shiftTypeId;
        $this->pageNumber = $pageNumber;
        $this->pageItems = $pageItems;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $daysFrom = $this->shiftCalendar->daysFrom(
            $this->startTime,
            $this->shiftTypeId,
            $this->pageNumber,
            $this->pageItems
        );

        $shiftDayList = [];

        foreach ($daysFrom as $day) {
            $shiftDayList[] = $day->array();
        }

        $daysTotal = $this->shiftCalendar->dayCount($this->startTime, $this->shiftTypeId);
        $daysFrom = (($this->pageNumber - 1) * $this->pageItems) + 1;
        $daysTo = $this->pageNumber * $this->pageItems;
        if ($daysTo > $daysTotal) {
            $daysTo = $daysTotal;
        }

        return $output
            ->withMetadata(
                'Accept-Ranges',
                'count'
            )
            ->withMetadata(
                'Content-Range',
                "count ${daysFrom}-${daysTo}/${daysTotal}"
            )
            ->withMetadata(
                'Content-Type',
                'application/json'
            )
            ->withMetadata(
                PageInterface::BODY,
                json_encode($shiftDayList)
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === PageInterface::QUERY) {
            $query = new SimpleFormData($value);

            return new self(
                $this->shiftCalendar,
                new \DateTimeImmutable($query->param('start-time')),
                (int) $query->param('shift-type-id'),
                (int) $query->paramWithDefault('page-number', '1'),
                (int) $query->paramWithDefault('page-items', '10'),
            );
        }

        return $this;
    }
}