<?php

namespace App\Document;

class RequestLimit
{
    const DEFAULT_MAX_ATTEMPT = 2;
    const DEFAULT_MAX_WORKDAYS = 5;

    /** @var int */
    private $maxAttempt;

    /** @var int */
    private $maxWorkdays;

    /** @var array */
    private $workdays;

    /**
     * @param int $maxAttempt
     * @param int $maxWorkdays
     * @param array $workdays
     */
    public function __construct(
        int $maxAttempt,
        int $maxWorkdays,
        array $workdays = null
    ) {

        $this->maxAttempt = $maxAttempt;
        $this->maxWorkdays = $maxWorkdays;
        $this->workdays = $workdays;
    }

    /**
     * Get the value of maxAttempt
     */
    public function getMaxAttempt(): int
    {
        return $this->maxAttempt;
    }

    /**
     * Get the value of maxWorkdays
     */
    public function getMaxWorkdays(): int
    {
        return $this->maxWorkdays;
    }

    /**
     * Get the value of workdays
     */
    public function getWorkdays(): array
    {
        return $this->workdays;
    }
}
