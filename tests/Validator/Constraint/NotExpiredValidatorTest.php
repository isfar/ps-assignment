<?php

namespace App\Tests\Validator\Constraint;

use App\Document\DocumentType;
use App\Document\ValidityPeriod;
use App\Validator\Constraint\NotExpired;
use App\Validator\Constraint\NotExpiredValidator;
use DateTimeImmutable;
use ReflectionMethod;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class NotExpiredValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new NotExpiredValidator();
    }

    /**
     * @dataProvider provideTestCalculatePeriod
     */
    public function testCalculatePeriod(
        $issueDate,
        $documentType,
        $periods,
        $expected
    ) {


        $notExpiredValidator = new NotExpiredValidator($issueDate, new NotExpired([
            'today' => '2019-10-27',
            'periods' => $periods,
            'documentType' => $documentType
        ]));

        $calculatePeriodReflection = new ReflectionMethod(NotExpiredValidator::class, 'calculatePeriod');
        $calculatePeriodReflection->setAccessible(true);

        $output = $calculatePeriodReflection->invokeArgs($notExpiredValidator, [
            $issueDate,
            $documentType,
            $periods
        ]);

        $this->assertEquals($expected, $output);

    }

    public function provideTestCalculatePeriod()
    {
        return [
            [
                '2012-10-23',
                'passport',
                [
                    new ValidityPeriod(5),
                ],
                5
            ],
            [
                '2012-10-23',
                'passport',
                [
                    new ValidityPeriod(5),
                    new ValidityPeriod(10, ['passport'], '2010-01-01'),
                ],
                10
            ],
            [
                '2012-10-23',
                'passport',
                [
                    new ValidityPeriod(10, ['passport'], '2010-01-01'),
                    new ValidityPeriod(5),
                ],
                10
            ],
            [
                '2012-10-23',
                'passport',
                [
                    new ValidityPeriod(10, null, '2010-01-01'),
                    new ValidityPeriod(5),
                ],
                10
            ],
            [
                '2012-10-23',
                'passport',
                [
                    new ValidityPeriod(10, null, null, '2010-10-10'),
                    new ValidityPeriod(5),
                ],
                5
            ],
            [
                '2012-10-23',
                'passport',
                [
                    new ValidityPeriod(10, null, '2010-10-10', '2030-10-10'),
                    new ValidityPeriod(5),
                ],
                10
            ],
            [
                '2012-10-23',
                'identity_card',
                [
                    new ValidityPeriod(10, [ 'passport' ], '2010-01-01'),
                    new ValidityPeriod(5),
                ],
                5
            ],
        ];
    }

    /**
     * @dataProvider provideTestIsExpired
     */
    public function testIsExpired(
        string $strDate,
        int $period,
        bool $expected
    ) {
        $strNow = '2019-10-25';
        $now = new DateTimeImmutable($strNow);

        $date = new DateTimeImmutable($strDate);

        $notExpiredValidator = new NotExpiredValidator();

        $isExpiredReflected = new ReflectionMethod(NotExpiredValidator::class, 'isExpired');
        $isExpiredReflected->setAccessible(true);

        $output = $isExpiredReflected->invokeArgs($notExpiredValidator, [
            $now,
            $date,
            $period
        ]);

        $this->assertEquals($expected, $output);
    }    

    public function provideTestIsExpired()
    {
        return [
            [ '2014-10-24', 5, true ],
            [ '2014-10-26', 5, false ],
            [ '2012-10-26', 10, false ],
            [ '2012-10-26', 5, true ],
        ];
    }

    /**
     * @dataProvider provideTestValidate
     */
    public function testValidate(
        string $issueDate,
        string $today,
        string $documentType,
        array $periods,
        bool $shouldViolate
    ) {
        $this->validator->validate(
            $issueDate,
            new NotExpired([
                'today' => $today,
                'periods' => $periods,
                'documentType' => $documentType
            ])
        );

        if ($shouldViolate) {
            $this
                ->buildViolation('{{ message }}')
                ->setParameter('{{ message }}', "document_is_expired")
                ->assertRaised();
        } else {
            $this->assertNoViolation();
        }
    }

    public function provideTestValidate()
    {
        return [
            [ 
                '2017-10-25', 
                '2019-10-24',
                'passport',
                [
                    new ValidityPeriod(5)
                ],
                false
            ],
            [ 
                '2011-10-25', 
                '2019-10-24',
                'passport',
                [
                    new ValidityPeriod(5)
                ],
                true
            ],
            [ 
                '2011-10-25', 
                '2019-10-24',
                'passport',
                [
                    new ValidityPeriod(5),
                    new ValidityPeriod(10, null, '2010-10-10'),
                ],
                false
            ],
        ];
    }
}