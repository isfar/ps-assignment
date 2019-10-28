<?php

namespace App\Tests\Validator\Constraint;

use App\Validator\Constraint\InArray;
use App\Validator\Constraint\NotInRange;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class NotInRangeTest extends TestCase
{
    public function testOptionsCanBeSet()
    {
        $min = '13434';
        $max = '20990';

        $notInRange = new NotInRange([
            'min' => $min,
            'max' => $max
        ]);

        $this->assertEquals($max, $notInRange->max);
        $this->assertEquals($min, $notInRange->min);
    }
}