<?php

namespace App\Tests\Validator\Constraint;

use App\Validator\Constraint\Workday;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

class WorkdayTest extends TestCase
{
    public function testInvalidOptionsTriggersException()
    {
        $this->expectException(InvalidOptionsException::class);

        new Workday([
            'workdays' => "Not an array"
        ]);
    }

    public function testInvalidWorkdaysTriggersException()
    {
        $this->expectException(InvalidOptionsException::class);

        new Workday([
            'workdays' => [
                'Not an instance of Workdays'
            ]
        ]);
    }

    public function testOptionsCanBeSet()
    {
        $workdays = [];

        $Workday = new Workday([
            'workdays' => []
        ]);

        $this->assertEquals($workdays, $Workday->workdays);
    }
}
