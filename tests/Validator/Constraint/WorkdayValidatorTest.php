<?php

namespace App\Tests\Validator\Constraint;

use App\Document\Weekdays;
use App\Util\Day;
use App\Validator\Constraint\Workday;
use App\Validator\Constraint\WorkdayValidator;
use ReflectionMethod;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class WorkdayValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new WorkdayValidator();
    }

    /**
     * @dataProvider provideValidateData
     */
    public function testValidate(
        $issueDate,
        $workdays,
        $violates
    ) {
        $this->validator->validate($issueDate, new Workday([
            'workdays' => $workdays
        ]));

        if (!$violates) {
            $this->assertNoViolation();
        } else {
            $this
                ->buildViolation('{{ message }}')
                ->setParameter('{{ message }}', "'$issueDate' is not an workday.")
                ->assertRaised();
        }
    }

    public function provideValidateData()
    {
        $workingDays = new Weekdays([ 'Mon', 'Tue', 'Wed', 'Thu', 'Fri']);

        return [
            [
                '2019-10-25',
                [ $workingDays ],
                false
            ],
            [
                '2019-10-26',
                [ $workingDays ],
                true
            ],
        ];
    }

    /**
     * @dataProvider provideIsDateOnWorkdayData
     */
    public function testIsDateOnWorkday(
        $date,
        $workdays,
        $expected
    ) {
        $isDateOnWorkdayReflection = new ReflectionMethod(
            WorkdayValidator::class,
            'isDateOnWorkday'
        );
        $isDateOnWorkdayReflection->setAccessible(true);

        $wokrdayValidator = new WorkdayValidator($date, new Workday([
            'workdays' => $workdays
        ]));

        $output = $isDateOnWorkdayReflection->invokeArgs($wokrdayValidator, [
            $date,
            $workdays
        ]);

        $this->assertEquals($expected, $output);
    }

    public function provideIsDateOnWorkdayData()
    {
        $weekdays = [
            Day::MON,
            Day::TUE,
            Day::WED,
            Day::THU,
            Day::FRI,
        ];

        return [
            [
                '2019-10-26',
                [
                    new Weekdays($weekdays)
                ],
                false
            ],
            [
                '2019-10-26',
                [
                    new Weekdays($weekdays),
                    new Weekdays([ Day::SAT ], '2019-01-01', '2019-12-31'),
                ],
                true
            ],
            [
                '2019-10-26',
                [
                    new Weekdays($weekdays),
                    new Weekdays([ Day::SAT ], '2019-01-01', '2019-02-31'),
                ],
                false
            ],
        ];
    }
}
