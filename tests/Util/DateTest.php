<?php

namespace App\Tests\Util;

use App\Util\Date;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    /**
     * @dataProvider provideIsValidData
     */
    public function testIsValid(
        $date,
        $expected
    ) {
        $output = Date::isValid($date);

        $this->assertEquals($expected, $output);
    }

    public function provideIsValidData()
    {
        return [
            ['1900-01-01', true],
            ['1700-01-01', true],
            ['1905-1-01', true],
            ['1905-1-35', false],
            ['1905-13-31', false],
            ['1905-10-31', true],
            ['2012-10-23', true],
        ];
    }
}
