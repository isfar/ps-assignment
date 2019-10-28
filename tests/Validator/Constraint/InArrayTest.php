<?php

namespace App\Tests\Validator\Constraint;

use App\Validator\Constraint\InArray;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class InArrayTest extends TestCase
{
    public function testInvalidArgumentTriggersException()
    {
        $this->expectException(InvalidArgumentException::class);

        $inArray = new InArray([
            'array' => "Not an array"
        ]);
    }

    public function testArrayCanBeSet()
    {
        $inArray = new InArray([
            'array' => []
        ]);

        $this->assertEquals([], $inArray->array);
    }
}