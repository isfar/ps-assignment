<?php

namespace App\Tests\Validator\Constraint;

use App\Validator\Constraint\NotInRange;
use App\Validator\Constraint\NotInRangeValidator;
use ReflectionMethod;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class NotInRangeValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new NotInRangeValidator();
    }

    /**
     * @dataProvider provideTestInRange
     */
    public function testInRange(
        $value,
        $lower,
        $upper,
        $expected
    ) {
        $value = '345678';
        $lower = '100000';
        $upper = '450000';
        $expected = true;

        $notInRangeValidator = new NotInRangeValidator();

        $inRangeReflected  = new ReflectionMethod(
            NotInRangeValidator::class,
            'inRange'
        );
        $inRangeReflected->setAccessible(true);

        $output = $inRangeReflected->invokeArgs($notInRangeValidator, [
            $value,
            $lower,
            $upper
        ]);
        
        $this->assertEquals($expected, $output);

    }

    public function provideTestInRange()
    {
        return [
            [ '345678', '100000', '450000', true ],
            [ '3456788', '100000', '450000', false ],
            [ '23459', '23459', '40000', true ],
            [ '2345', '1000', '2345', true ],
            [ 345, 34, 45, false ],
        ];
    }

    /**
     * @dataProvider provideTestValidate
     */
    public function testValidate(
        $value,
        $min,
        $max,
        $violates
    ) {
        $this->validator->validate($value, new NotInRange([
            'min' => $min,
            'max' => $max,
        ]));

        if ($violates) {
             $this
                ->buildViolation('{{ message }}')
                ->setParameter('{{ message }}', "document_number_invalid")
                ->assertRaised();

        } else {
            $this->assertNoViolation();
        }
    }

    public function provideTestValidate()
    {
        return [
            [ '34', '456', '100000', false, ],
            [ '7890', '456', '100000', true, ]
        ];
    }
}
