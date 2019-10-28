<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotInBlacklistValidator extends ConstraintValidator
{
    public function validate($documentId, Constraint $constraint)
    {
        if ($this->isBlacklisted($documentId, $constraint->documentType, $constraint->blacklists)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ message }}', "document_number_invalid")
                ->addViolation()
                ;
        }
    }

    private function isBlacklisted(
        $documentId,
        $documentType,
        $blacklists
    ) {
        foreach ($blacklists as $blacklist) {
            $min = $blacklist->getMin();
            $max = $blacklist->getMax();
            $documentTypes = $blacklist->getDocumentTypes();

            if (in_array($documentType, $documentTypes)) {
                if (
                    ($min && $max && $documentId >= $min && $documentId <= $max)
                    || ($min && !$max && $documentId >= $min)
                    || (!$min && $max && $documentId <= $max)
                ) {
                    return true;
                }
            }
        }

        return false;
    }
        
}
