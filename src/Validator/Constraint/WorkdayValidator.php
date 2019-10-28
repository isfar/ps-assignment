<?php

namespace App\Validator\Constraint;

use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class WorkdayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$this->isDateOnWorkday($value, $constraint->workdays)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ message }}', "'$value' is not an workday.")
                ->addViolation()
                ;
        }
    }

    private function isDateOnWorkday(
        string $date,
        array $workdays
    ) {
        $day = (new DateTime($date))->format('D');

        foreach ($workdays as $workingDays) {
            $startDate = $workingDays->getStartDate();
            $endDate = $workingDays->getEndDate();

            if (in_array($day, $workingDays->getDays())) {
                if (
                    ($startDate && $endDate && $date >= $startDate && $date <= $endDate)
                    || ($startDate && !$endDate && $date >= $startDate)
                    || (!$startDate && $endDate && $date <= $endDate)
                    || (!$startDate && !$endDate)
                ) {
                    return true;
                }
            }
        }

        return false;
    }
        
}
