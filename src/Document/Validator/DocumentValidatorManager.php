<?php

namespace App\Document\Validator;

class DocumentValidatorManager
{
    private $services = [];

    public function register(string $key, DocumentValidatorInterface $documentValidator): self
    {
        $this->services[$key] = $documentValidator;
        return $this;
    }

    public function get(string $key): ?DocumentValidatorInterface
    {
        if (isset($this->services[$key]) && $this->services[$key] instanceof DocumentValidatorInterface) {
            return $this->services[$key];
        }

        throw new \Exception("No Document Validator registered with the key: $key");
    }
}
