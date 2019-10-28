<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotInRangeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($this->inRange($value, $constraint->min, $constraint->max)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ message }}', 'document_number_invalid')
                ->addViolation()
                ;
        }
    }

    private function inRange(
        $value,
        string $lower,
        string $upper
    ): bool {
        if ($value >= $lower && $value <= $upper) {
            return true;
        }

        return false;
    }

}
