<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidDocumentTypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        if (!$this->isValid($value, $constraint->issueDate, $constraint->types)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ message }}', "invalid_document_type")
                ->addViolation();
        }
    }

    private function isValid(
        string $documentType,
        string $issueDate,
        array $types
    ) {
        foreach ($types as $type) {
            $validFrom = $type->getValidFrom();
            $validTill = $type->getValidTill();

            if ($documentType === $type->getType()) {
                if (
                    ($validFrom && $validTill && $issueDate >= $validFrom && $issueDate <= $validTill)
                    || ($validFrom && !$validTill && $issueDate >= $validFrom)
                    || (!$validFrom && $validTill && $issueDate <= $validTill)
                    || (!$validFrom && !$validTill)
                ) {
                    return true;
                }
            }
        }

        return false;
    }
}
