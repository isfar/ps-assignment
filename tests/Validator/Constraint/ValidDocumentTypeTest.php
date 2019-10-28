<?php

namespace App\Tests\Validator\Constraint;

use App\Validator\Constraint\ValidDocumentType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

class ValidDocumentTypeTest extends TestCase
{
    public function testInvalidOptionsTriggersException()
    {
        $this->expectException(InvalidOptionsException::class);

        new ValidDocumentType([
            'types' => "Not an array",
            'issueDate' => '2014-01-01',
        ]);
    }

    public function testInvalidTypesTriggersException()
    {
        $this->expectException(InvalidOptionsException::class);

        new ValidDocumentType([
            'types' => [
                'Not an instance of Workdays'
            ],
            'issueDate' => '2014-01-01',
        ]);
    }

    public function testOptionsCanBeSet()
    {
        $types = [];
        $issueDate = '2014-01-01';

        $validDocumentType = new ValidDocumentType([
            'types' => [],
            'issueDate' => $issueDate,
        ]);

        $this->assertEquals($types, $validDocumentType->types);
        $this->assertEquals($issueDate, $validDocumentType->issueDate);
    }
}
