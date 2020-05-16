<?php

namespace App\Document\Validator;

use App\Document\RequestLimit;

class Config
{
    const DEFAULT_DATE_FORMAT = 'Y-m-d';

    /** @var string */
    private $dateFormat;

    /** @var array Array containing string */
    private $countryCodes;

    /** @var array Array containing instances of DocumentType */
    private $documentTypes;

    /** @var array Array containing instances of ValidityPeriod */
    private $validityPeriods;

    /** @var array Array containing instances of Length */
    private $idLengths;

    /** @var array Array containing instances of Weekdays */ private $workdays;

    /** @var array Array containing instances of Blacklist */
    private $blacklists;

    /** @var RequestLimit */
    private $requestLimit;

    public function setCountryCodes(?array $countryCodes): self
    {
        $this->countryCodes = $countryCodes;
        return $this;
    }

    public function getCountryCodes(): ?array
    {
        return $this->countryCodes ?? CountryCode::$list;
    }

    public function setDateFormat(?string $dateFormat): self
    {
        $this->dateFormat = $dateFormat;
        return $this;
    }

    public function getDateFormat(): ?string
    {
        return $this->dateFormat ?? self::DEFAULT_DATE_FORMAT;
    }

    public function setDocumentTypes(?array $types): self
    {
        $this->documentTypes = $types;
        return $this;
    }

    public function getDocumentTypes(): ?array
    {
        return $this->documentTypes ?? [];
    }

    public function setIdLengths(?array $lengths): self
    {
        $this->idLengths = $lengths;
        return $this;
    }

    public function getIdLengths(): ?array
    {
        return $this->idLengths ?? [];
    }

    public function setWorkdays(?array $workdays): self
    {
        $this->workdays = $workdays;
        return $this;
    }

    public function getWorkdays(): ?array
    {
        return $this->workdays ?? [];
    }

    public function getValidityPeriods(): array
    {
        return $this->validityPeriods ?? [];
    }

    public function setValidityPeriods(?array $validityPeriods): self
    {
        $this->validityPeriods = $validityPeriods;
        return $this;
    }

    public function getBlacklists(): ?array
    {
        return $this->blacklists ? $this->blacklists : [];
    }

    /**
     * @return  self
     */
    public function setBlacklists(?array $blacklists): self
    {
        $this->blacklists = $blacklists;
        return $this;
    }

    /**
     * Get the value of requestLimit
     */
    public function getRequestLimit(): ?RequestLimit
    {
        return $this->requestLimit;
    }

    /**
     * Set the value of requestLimit
     * @return  self
     */
    public function setRequestLimit(?RequestLimit $requestLimit): self
    {
        $this->requestLimit = $requestLimit;
        return $this;
    }
}
