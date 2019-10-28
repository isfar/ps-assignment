<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidLengthValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $length = strlen($value);

        if (!$this->isValid($length, $constraint->documentType, $constraint->issueDate, $constraint->lengths)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ message }}', "document_number_length_invalid")
                ->addViolation();
        }
    }

    private function isValid(
        int $intLength,
        string $documentType,
        string $issueDate,
        array $lengths
    ) {
        foreach ($lengths as $length) {
            $validFrom = $length->getValidFrom();
            $validTill = $length->getValidTill();
            $documentTypes = $length->getDocumentTypes();

            if (empty($documentTypes) || in_array($documentType, $documentTypes)) {
                if (
                    ($validFrom && $validTill && $issueDate >= $validFrom && $issueDate <= $validTill)
                    || ($validFrom && !$validTill && $issueDate >= $validFrom)
                    || (!$validFrom && $validTill && $issueDate <= $validTill)
                    || (!$validFrom && !$validTill)
                ) {
                    return $length->getLength() === $intLength;
                }
            }
        }

        return false;
    }
}
