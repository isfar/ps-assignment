<?php

namespace App\Tests\Validator\Constraint;

use App\Validator\Constraint\DateOnDays;
use App\Validator\Constraint\DateOnDaysValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class DateOnDaysValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new DateOnDaysValidator();
    }

    /**
     * @dataProvider getValidateData
     */
    public function testValidate($array, $value, $violates)
    {
        $this->validator->validate($value, new DateOnDays([
            'days' => $array
        ]));

        if (!$violates) {
            $this->assertNoViolation();
        } else {
            $this
                ->buildViolation('{{ message }}')
                ->setParameter('{{ message }}', "'$value' not on one of the specified days.")
                ->assertRaised();
        }

    }

    public function getValidateData()
    {
        return [
            [
                [],
                '',
                true,
            ],
            [
                [ 'Wed', 'Thu' ],
                '2019-10-23',
                false
            ],
            [
                [ 'Wed', 'Thu' ],
                '2019-10-26',
                true
            ],
        ];
    }

}

