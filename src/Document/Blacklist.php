<?php

namespace App\Document;

class Blacklist
{
    /** @var array */
    private $documentTypes;

    /** @var string */
    private $min;

    /** @var string */
    private $max;

    /**
     * @param array $documentTypes  array of instances of strings
     * @param string $min optional
     * @param string $max optional
     */
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
