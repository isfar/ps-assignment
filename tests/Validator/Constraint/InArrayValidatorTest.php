<?php

namespace App\Tests\Validator\Constraint;

use App\Validator\Constraint\InArray;
use App\Validator\Constraint\InArrayValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class InArrayValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new InArrayValidator();
    }

    /**
     * @dataProvider getValidateData
     */
    public function testValidate($array, $value, $violates)
    {
        $this->validator->validate($value, new InArray([
            'array' => $array
        ]));

        if (!$violates) {
            $this->assertNoViolation();
        } else {
            $this
                ->buildViolation('{{ message }}')
                ->setParameter('{{ message }}', "'$value' not in array.")
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
                'Fri',
                true
            ],
            [
                [ 'Wed', 'Thu' ],
                'Thu',
                false
            ],
        ];
    }

}

