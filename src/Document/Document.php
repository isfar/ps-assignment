<?php

namespace App\Document;

class Document
{
    // @var string
    private $id;

    // @var string
    private $ownerId;

    // @var string
    private $type;

    // @var string
    private $requestDate;

    // @var string
    private $issueDate;

    // @var string
    private $countryCode;

    /**
     * @param string $id
     * @param string $ownerId
     * @param string $type
     * @param string $requestDate
     * @param string $issueDate
     * @param string $countryCode
     */
    public function __construct(
        string $id = null,
        string $ownerId = null,
        string $type = null,
        string $requestDate = null,
        string $issueDate = null,
        string $countryCode = null
    ) {
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->type = $type;
        $this->requestDate = $requestDate;
        $this->issueDate = $issueDate;
        $this->countryCode = $countryCode;
    }


    public function toArray(): array
    {
        return [
            'requestDate' => $this->getRequestDate(),
            'type' => $this->getType(),
            'id' => $this->getId(),
            'issueDate' => $this->getIssueDate(),
            'ownerId' => $this->getOwnerId(),
        ];
    }

    /**
     * Get the value of id
     */ 
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     * @return  self
     */ 
    public function setId(?srting $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of ownerId
     */ 
    public function getOwnerId(): ?string
    {
        return $this->ownerId;
    }

    /**
     * Set the value of ownerId
     * @return  self
     */ 
    public function setOwnerId(?string $ownerId): self
    {
        $this->ownerId = $ownerId;
        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     * @return  self
     */ 
    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get the value of requestDate
     */ 
    public function getRequestDate(): ?string
    {
        return $this->requestDate;
    }

    /**
     * Set the value of requestDate
     * @return  self
     */ 
    public function setRequestDate(?string $requestDate): self
    {
        $this->requestDate = $requestDate;
        return $this;
    }

    /**
     * Get the value of issueDate
     */ 
    public function getIssueDate(): ?string
    {
        return $this->issueDate;
    }

    /**
     * Set the value of issueDate
     * @return  self
     */ 
    public function setIssueDate(?string $issueDate): self
    {
        $this->issueDate = $issueDate;
        return $this;
    }

    /**
     * Get the value of countryCode
     */ 
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * Set the value of countryCode
     *
     * @return  self
     */ 
    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;
        return $this;
    }
}