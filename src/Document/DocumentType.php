<?php

namespace App\Document;

class DocumentType
{
    const PASSPORT          = 'passport';
    const IDENTITY_CARD     = 'identity_card';
    const DRIVING_LICENSE   = 'drivers_license';
    const RESIDENCE_PERMIT  = 'residence_permit';
    
    public static $list = [
        self::PASSPORT,
        self::IDENTITY_CARD,
        self::DRIVING_LICENSE,
        self::RESIDENCE_PERMIT,
    ];

    /** @var string */
    private $type;

    /** @var string */
    private $validFrom;

    /** @var string */
    private $validTill;

    /**
     * @param string $type
     * @param string $validFrom
     * @param string $validTill
     */
    public function __construct(
        string $type,
        string $validFrom = null,
        string $validTill = null
    ) {
        $this->type = $type;
        $this->validFrom = $validFrom;
        $this->validTill = $validTill;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValidFrom(): ?string
    {
        return $this->validFrom;
    }

    public function getValidTill(): ?string
    {
        return $this->validTill;
    }
}
