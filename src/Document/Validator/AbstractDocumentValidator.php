<?php

namespace App\Document\Validator;

use App\Document\CountryCode;
use App\Document\Document;
use App\Document\DocumentType;
use App\Document\Length;
use App\Document\ValidityPeriod;
use App\Document\Weekdays;
use App\Storage\StorageInterface;
use App\Validator\Constraint\InArray;
use App\Validator\Constraint\NotExpired;
use App\Validator\Constraint\NotInBlacklist;
use App\Validator\Constraint\NotTooManyAttempt;
use App\Validator\Constraint\ValidDocumentType;
use App\Validator\Constraint\ValidLength;
use App\Validator\Constraint\Workday;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AbstractDocumentValidator implements DocumentValidatorInterface
{
    const DEFAULT_EXPIRY_PERIOD = 5;

    const DEFAULT_ID_LENGTH = 8;

    const DEFAULT_REQUEST_LIMIT = 2;

    const DEFAULT_REQUEST_WORKDAY_LIMIT = 5;

    const DEFAULT_DATE_FORMAT = "Y-m-d";

    const DEFAULT_WORKDAYS = Weekdays::DEFAULT;

    const DEFAULT_DOCUMENT_TYPES = [
        DocumentType::IDENTITY_CARD,
        DocumentType::PASSPORT,
        DocumentType::RESIDENCE_PERMIT
    ];

    /** @var Document */
    private $document;

    /** @var string */
    private $dateFormat;

    /** @var array */
    private $countryCodes;

    /** @var array */
    private $documentTypes;

    /** @var array */
    private $validityPeriods;

    /** @var array */
    private $idLengths;

    /** @var array */
    private $workdays;

    /** @var array */
    private $blacklists;

    private $requestLimit;

    private $requestWorkdayLimit;

    /** @var StorageInterface */
    private $storage;

    public function __construct(
        StorageInterface $storage
    ) {
        $this->storage = $storage;
    }

    public function validate(Document $document, ValidatorInterface $validator): ConstraintViolationListInterface
    {
        $this->setDocument($document);

        return $validator->validate($document->toArray(), $this->getConstraints());
    }

    private function getConstraints(): array
    {
        $today = date(self::DEFAULT_DATE_FORMAT);

        return [
            new Assert\Type('array'),
            new Assert\Collection([
                'allowMissingFields' => true,
                'allowExtraFields' => true,
                'fields' => [
                    'type' => new ValidDocumentType([
                        'types' => $this->getDocumentTypes(),
                        'issueDate' => $this->document->getIssueDate(),
                        'message' => 'document_type_is_invalid',
                    ]),
                    'issueDate' => [
                        new Assert\DateTime([
                            'format' => $this->getDateFormat(),
                            'message' => 'document_issue_date_invalid',
                        ]),
                        new NotExpired([
                            'today' => $today,
                            'documentType' => $this->getDocument()->getType(),
                            'periods' => $this->getValidityPeriods(),
                            'message' => 'document_is_expired',
                        ]),
                        new Workday([
                            'workdays' => $this->getWorkdays(),
                            'message' => 'document_issue_date_invalid',
                        ]),

                    ],
                    'id' => [
                        new ValidLength([
                            'issueDate' => $this->document->getIssueDate(),
                            'documentType' => $this->getDocument()->getType(),
                            'lengths' => $this->getIdLengths(),
                            'message' =>  'document_number_length_invalid'
                        ]),
                        new NotInBlacklist([
                            'documentType' => $this->document->getType(),
                            'blacklists' => $this->getBlacklists(),
                        ]),
                    ],
                    'ownerId' => [
                        new NotTooManyAttempt([
                            'today' => $this->getDocument()->getRequestDate(),
                            'maxAllowed' => $this->getRequestLimit(),
                            'numWorkdays' => $this->getRequestWorkdayLimit(),
                            'workdays' => Weekdays::DEFAULT,
                            'storage' => $this->getStorage(),
                            'message' => 'request_limit_exceeded',
                        ]),
                    ],
                    'countryCode' => new InArray([
                        'array' => $this->getCountryCodes(),
                        'message' => 'country_code_is_invalid',
                    ]),
                ]
            ]),
        ];
    }

    public function setDocument(Document $document): self
    {
        $this->document = $document;
        return $this;
    }

    public function getDocument(): Document
    {
        return $this->document;
    }

    public function setStorage(StorageInterface $storage): self
    {
        $this->storage = $storage;
        return $this;
    }

    public function getStorage(): StorageInterface
    {
        return $this->storage;
    }

    public function setCountryCodes(?array $countryCodes): self
    {
        $this->countryCodes = $countryCodes;
        return $this;
    }

    public function getCountryCodes(): ?array
    {
        return $this->countryCodes ? $this->countryCodes : CountryCode::$list;
    }

    public function setDateFormat(?string $dateFormat): self
    {
        $this->dateFormat = $dateFormat;
        return $this;
    }

    public function getDateFormat(): ?string
    {
        return $this->dateFormat ? $this->dateFormat : self::DEFAULT_DATE_FORMAT;
    }

    public function setDocumentTypes(?array $types): self
    {
        $this->documentTypes = $types;
        return $this;
    }

    public function getDocumentTypes(): ?array
    {
        return $this->documentTypes
            ? $this->documentTypes
            : array_map(function ($type) {
                return new DocumentType($type);
            }, self::DEFAULT_DOCUMENT_TYPES);
    }

    public function setIdLengths(?array $lengths): self
    {
        $this->idLengths = $lengths;
        return $this;
    }

    public function getIdLengths(): ?array
    {
        return $this->idLengths ? $this->idLengths : [
            new Length(self::DEFAULT_ID_LENGTH)
        ];
    }

    public function setWorkdays(?array $workdays): self
    {
        $this->workdays = $workdays;
        return $this;
    }

    public function getWorkdays(): ?array
    {
        return $this->workdays ? $this->workdays : [
            new Weekdays(Weekdays::DEFAULT),
        ];
    }

    public function getRequestLimit(): ?int
    {
        return $this->requestLimit !== null ? $this->requestLimit : self::DEFAULT_REQUEST_LIMIT;
    }

    public function setRequestLimit(?int $requestLimit): self
    {
        $this->requestLimit = $requestLimit;
        return $this;
    }

    public function getRequestWorkdayLimit(): ?int
    {
        return $this->requestWorkdayLimit !== null ? $this->requestWorkdayLimit : self::DEFAULT_REQUEST_WORKDAY_LIMIT;
    }

    public function setRequestWorkdayLimit(?int $requestWorkdayLimit): self
    {
        $this->requestWorkdayLimit = $requestWorkdayLimit;
        return $this;
    }

    public function getValidityPeriods(): array
    {
        return $this->validityPeriods ? $this->validityPeriods : [
            new ValidityPeriod(self::DEFAULT_EXPIRY_PERIOD)
        ];
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
}
