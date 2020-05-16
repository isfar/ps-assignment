<?php

namespace App\Tests\Validator\Constraint;

use App\Document\DocumentType;
use App\Validator\Constraint\ValidLength;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

class ValidLengthTest extends TestCase
{
    public function testInvalidOptionsTriggersException()
    {
        $this->expectException(InvalidOptionsException::class);

        new ValidLength([
            'lengths' => "Not an array",
            'issueDate' => '2014-01-01',
            'documentType' => DocumentType::PASSPORT,
        ]);
    }

    public function testInvalidLengthsTriggersException()
    {
        $this->expectException(InvalidOptionsException::class);

        new ValidLength([
            'lengths' => [
                'Not an instance of Workdays'
            ],
            'issueDate' => '2014-01-01',
            'documentType' => DocumentType::PASSPORT,
        ]);
    }

    public function testOptionsCanBeSet()
    {
        $lengths = [];
        $issueDate = '2014-01-01';

        $validDocumentType = new ValidLength([
            'lengths' => [],
            'issueDate' => $issueDate,
            'documentType' => DocumentType::PASSPORT,
        ]);

        $this->assertEquals($lengths, $validDocumentType->lengths);
        $this->assertEquals($issueDate, $validDocumentType->issueDate);
    }
}
