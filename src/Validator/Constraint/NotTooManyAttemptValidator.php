<?php

namespace App\Validator\Constraint;

use DateTime;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotTooManyAttemptValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $date = $constraint->storage->getByOffset($value, -$constraint->maxAllowed);

        if ($date && $this->exceedsLimit(
            new DateTimeImmutable($date),
            new DateTimeImmutable($constraint->today),
            $constraint->numWorkdays,
            $constraint->workdays
        )) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ message }}', 'document_number_invalid')
                ->addViolation()
                ;
        }
    }

    public function exceedsLimit(
        DateTimeImmutable $from,
        DateTimeImmutable $today,
        int $numWorkdays,
        array $workdays
    ): bool
    {
        $startNextValidDate = (new DateTime())->setTimestamp($from->setTime(0, 0, 0)->getTimestamp());
        $today = (new DateTime())->setTimestamp($today->setTime(23, 59, 59)->getTimestamp());

        $i = 0;

        while ($i < $numWorkdays) {
            $startNextValidDate->modify('+1 day');

            if (in_array(
                $startNextValidDate->format('D'),
                $workdays
            )) {
                $i++;
            }
        }

        return $today < $startNextValidDate;
    }
}
