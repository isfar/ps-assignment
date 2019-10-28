<?php

namespace App\Validator\Constraint;

use App\Document\ValidityPeriod;
use DateInterval;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotExpiredValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $period = $this->calculatePeriod(
            $value,
            $constraint->documentType,
            $constraint->periods
        );

        $issuedAt = new DateTimeImmutable($value);
        $today = new DateTimeImmutable($constraint->today);

        if ($this->isExpired($today, $issuedAt, $period)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ message }}', 'document_is_expired')
                ->addViolation()
                ;
        }
    }

    private function isExpired(
        DateTimeImmutable $now,
        DateTimeImmutable $date,
        int $period
    ): bool {
        $validTill = $date->add(new DateInterval("P{$period}Y"));
        return $validTill < $now;
    }

    private function calculatePeriod(
        string $issueDate,
        string $documentType,
        array $periods
    ): int {
        $intPeriod = 0;

        foreach ($periods as $period) {
            $startDate = $period->getStartDate();
            $endDate = $period->getEndDate();

            if (
                null === $period->getDocumentTypes()
                || in_array($documentType, $period->getDocumentTypes())
            ) {
                if (
                    ($startDate && $endDate && $issueDate >= $startDate && $issueDate <= $endDate)
                    || (!$startDate && $endDate && $issueDate <= $endDate)
                    || ($startDate && !$endDate && $issueDate >= $endDate)
                    || (!$startDate && !$endDate)
                ) {
                    $intPeriod = $period->getPeriod() > $intPeriod ? $period->getPeriod() : $intPeriod;
                }
            }
        } // end foreach

        return $intPeriod;
    }
}