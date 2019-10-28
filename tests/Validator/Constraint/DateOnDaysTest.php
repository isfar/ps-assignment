<?php

namespace App\Tests\Validator\Constraint;

use App\Validator\Constraint\DateOnDays;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class DateOnDaysTest extends TestCase
{
    public function testInvalidArgumentTriggersException()
    {
        $this->expectException(InvalidArgumentException::class);

        $dateOnDays = new DateOnDays([
            'days' => "Not an array"
        ]);
    }

    public function testDaysCanBeSet()
    {
        $dateOnDays = new DateOnDays([
            'days' => []
        ]);

        $this->assertEquals([], $dateOnDays->days);
    }
}