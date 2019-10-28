<?php

namespace App\Document;

class ValidityPeriod
{
    private $documentTypes;

    private $startDate;

    private $endDate;

    private $period;

    public function __construct(
        int $period,
        array $documentTypes = null,
        string $startDate = null,
        string $endDate = null
    ) {
        $this->period = $period;
        $this->documentTypes = $documentTypes;
        $this->startDate = $startDate;        
        $this->endDate = $endDate;        
    }

    public function setDocumentTypes(array $types): self
    {
        $this->documentTypes = $types;
        return $this;
    }

    public function getDocumentTypes(): ?array
    {
        return $this->documentTypes;
    }

    public function setStartDate(?string $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setEndDate(?string $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function getPeriod(): ?int
    {
        return $this->period;
    }

    public function setPeriod(?int $period): self
    {
        $this->period = $period;
        return $this;
    }
}