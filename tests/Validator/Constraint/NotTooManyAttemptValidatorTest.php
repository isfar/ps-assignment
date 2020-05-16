<?php

namespace App\Tests\Validator\Constraint;

use App\Document\RequestLimit;
use App\Document\Weekdays;
use App\Storage\ArrayStorage;
use App\Validator\Constraint\NotTooManyAttempt;
use App\Validator\Constraint\NotTooManyAttemptValidator;
use DateTimeImmutable;
use ReflectionMethod;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class NotTooManyAttemptValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new NotTooManyAttemptValidator();
    }

    public function testValidateWithNoViolation()
    {
        $storage = $this->createMock(ArrayStorage::class);
        $storage
            ->expects($this->once())
            ->method('getByOffset')
            ->with('11111', -2)
            ->willReturn('2019-10-19');

        $this->validator->validate('11111', new NotTooManyAttempt([
            'today' => '2019-10-25',
            'limit' => new RequestLimit(2, 5, Weekdays::DEFAULT),
            'storage' => $storage,
        ]));

        $this->assertNoViolation();
    }


    public function testValidateWithViolation()
    {
        $storage = $this->createMock(ArrayStorage::class);
        $storage
            ->expects($this->once())
            ->method('getByOffset')
            ->with('11111', -2)
            ->willReturn('2019-10-21');
        
        $this->validator->validate('11111', new NotTooManyAttempt([
            'today' => '2019-10-25',
            'limit' => new RequestLimit(2, 5, Weekdays::DEFAULT),
            'storage' => $storage
        ]));

        $this
            ->buildViolation('{{ message }}')
            ->setParameter('{{ message }}', "document_number_invalid")
            ->assertRaised();
    }

    /**
     * @dataProvider provideExceedsLimitData
     */
    public function testExceedsLimit(
        $strFrom,
        $strNow,
        $expected
    ) {
        $numWorkdays = 5;
        $workdays = Weekdays::DEFAULT;

        $notTooManyAttemptValidator = new NotTooManyAttemptValidator(new ArrayStorage());
        $exceedsLimitReflected = new ReflectionMethod(NotTooManyAttemptValidator::class, 'exceedsLimit');
        $exceedsLimitReflected->setAccessible(true);

        $output = $exceedsLimitReflected->invokeArgs($notTooManyAttemptValidator, [
            new DateTimeImmutable($strFrom),
            new DateTimeImmutable($strNow),
            $numWorkdays,
            $workdays
        ]);

        $this->assertEquals($expected, $output);
    }

    public function provideExceedsLimitData()
    {
        return [
            [ '2019-10-19', '2019-10-25', false ],
            [ '2019-10-20', '2019-10-25', false ],
            [ '2019-10-21', '2019-10-25', true ],
        ];
    }
}
