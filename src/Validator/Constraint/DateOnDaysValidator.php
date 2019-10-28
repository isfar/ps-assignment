<?php

namespace App\Validator\Constraint;

use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateOnDaysValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $date = new DateTime($value);
        $day = $date->format('D');

        if (! in_array($day, $constraint->days)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ message }}', "'$value' not on one of the specified days.")
                ->addViolation()
                ;
        }
    }
}
