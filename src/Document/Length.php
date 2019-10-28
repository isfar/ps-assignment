<?php

namespace App\Document;

class Length
{
    const DEFAULT_LENGTH = 8;

    private $length;

    private $documentTypes;

    private $validFrom;

    private $validTill;

    public function __construct(
        int $length,
        ?array $documentTypes = null,
        ?string $validFrom = null,
        ?string $validTill = null
    ) {
        $this->length = $length;
        $this->documentTypes = $documentTypes;
        $this->validFrom = $validFrom;
        $this->validTill = $validTill;
    }

    public function getValidFrom(): ?string
    {
        return $this->validFrom;
    }

    public function getValidTill(): ?string
    {
        return $this->validTill;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getDocumentTypes()
    {
        return $this->documentTypes;
    }
}
