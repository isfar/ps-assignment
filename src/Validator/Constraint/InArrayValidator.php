<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class InArrayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (! in_array($value, $constraint->array)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ message }}', "'$value' not in array.")
                ->addViolation()
                ;
        }
    }
}
