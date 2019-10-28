<?php

namespace App\Document\Validator;

use App\Document\Document;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

interface DocumentValidatorInterface
{
    public function validate(Document $document, ValidatorInterface $validator): ConstraintViolationListInterface;
}