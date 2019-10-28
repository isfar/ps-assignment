<?php

namespace App\Document;

class Blacklist
{
    private $documentTypes;

    private $min;

    private $max;

    public function __construct(
        array $documentTypes,
        ?string $min = null,
        ?string $max = null
    ) {
        $this->documentTypes = $documentTypes;
        $this->min = $min;
        $this->max = $max;
    }

    public function getDocumentTypes(): ?array
    {
        return $this->documentTypes;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function getMax()
    {
        return $this->max;
    }
}