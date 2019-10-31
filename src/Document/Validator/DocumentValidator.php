<?php

namespace App\Document\Validator;

use App\Document\Document;
use App\Storage\StorageInterface;
use App\Validator\Constraint\NotExpired;
use App\Validator\Constraint\NotInBlacklist;
use App\Validator\Constraint\NotTooManyAttempt;
use App\Validator\Constraint\ValidDocumentType;
use App\Validator\Constraint\ValidLength;
use App\Validator\Constraint\Workday;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DocumentValidator implements DocumentValidatorInterface
{
    /** @var Document */
    private $document;

    /** @var StorageInterface */
    private $storage;

    /** @var Config */
    private $config;

    public function __construct(
        StorageInterface $storage,
        Config $config
    ) {
        $this->storage  = $storage;
        $this->config   = $config;
    }

    public function validate(Document $document, ValidatorInterface $validator): ConstraintViolationListInterface
    {
        $this->setDocument($document);

        return $validator->validate($document->toArray(), $this->getConstraints());
    }

    private function getConstraints(): array
    {
        $today = date($this->getConfig()->getDateFormat());

        return [
            new Assert\Type('array'),
            new Assert\Collection([
                'allowMissingFields' => true,
                'allowExtraFields' => true,
                'fields' => [
                    'type' => new ValidDocumentType([
                        'types' => $this->getConfig()->getDocumentTypes(),
                        'issueDate' => $this->getDocument()->getIssueDate(),
                        'message' => 'document_type_is_invalid',
                    ]),
                    'issueDate' => [
                        new Assert\DateTime([
                            'format' => $this->getConfig()->getDateFormat(),
                            'message' => 'document_issue_date_invalid',
                        ]),
                        new NotExpired([
                            'today' => $today,
                            'documentType' => $this->getDocument()->getType(),
                            'periods' => $this->getConfig()->getValidityPeriods(),
                            'message' => 'document_is_expired',
                        ]),
                        new Workday([
                            'workdays' => $this->getConfig()->getWorkdays(),
                            'message' => 'document_issue_date_invalid',
                        ]),
                    ],
                    'id' => [
                        new ValidLength([
                            'issueDate' => $this->getDocument()->getIssueDate(),
                            'documentType' => $this->getDocument()->getType(),
                            'lengths' => $this->getConfig()->getIdLengths(),
                            'message' =>  'document_number_length_invalid'
                        ]),
                        new NotInBlacklist([
                            'documentType' => $this->getDocument()->getType(),
                            'blacklists' => $this->getConfig()->getBlacklists(),
                        ]),
                    ],
                    'ownerId' => [
                        new NotTooManyAttempt([
                            'today' => $this->getDocument()->getRequestDate(),
                            'limit' => $this->getConfig()->getRequestLimit(),
                            'storage' => $this->getStorage(),
                            'message' => 'request_limit_exceeded',
                        ]),
                    ],
                    'countryCode' => new Choice([
                        'choices' => $this->getConfig()->getCountryCodes(),
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

    public function setConfig(Config $config): self
    {
        $this->config = $config;
        return $this;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }
}
