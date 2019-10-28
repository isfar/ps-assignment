<?php

namespace App\Document;

use App\Util\Day;

class Weekdays
{
    /** @var string */
    private $startDate;

    /** @var string */
    private $endDate;

    /** @var array */
    private $days;

    const DEFAULT = [
        Day::MON,
        Day::TUE,
        Day::WED,
        Day::THU,
        Day::FRI,
    ];

    /**
     * @param array $days
     * @param string $startDate
     * @param string $endDate
     */
    public function __construct(
        array $days,
        string $startDate = null,
        string $endDate = null
    ) {
        $this->days = $days;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function getDays(): ?array
    {
        return $this->days;
    }
}
