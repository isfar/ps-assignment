<?php

namespace App\Tests\Validator\Constraint;

use App\Document\DocumentType;
use App\Document\ValidityPeriod;
use App\Validator\Constraint\NotExpired;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

class NotExpiredTest extends TestCase
{
    public function testInvalidTodayTriggersException()
    {
        $this->expectException(InvalidOptionsException::class);

        new NotExpired([
            'today' => 'Invalid Date',
            'periods' => [
                new ValidityPeriod(5, DocumentType::$list),
            ],
            'documentType' => 'passport',
        ]);
    }

    public function testNonArrayPeriodTriggersException()
    {
        $this->expectException(InvalidOptionsException::class);

        new NotExpired([
            'today' => '2019-12-23',
            'periods' => 'Not an array',
            'documentType' => 'passport',
        ]);
    }

    public function testInvalidPeriodTriggersException()
    {
        $this->expectException(InvalidOptionsException::class);

        new NotExpired([
            'today' => '2019-12-23',
            'periods' => [
                'Not an instance of ValidityPeriod'
            ],
            'documentType' => 'passport',
        ]);
    }

    public function testInvalidDocumentTypeTriggersException()
    {
        $this->expectException(InvalidOptionsException::class);

        new NotExpired([
            'today' => '2019-12-23',
            'periods' => new ValidityPeriod(5, DocumentType::$list),
            'documentType' => 'Invalid document type',
        ]);
    }

    public function testOptionsCanBeSet()
    {
        $today = "2019-10-25";
        $periods = [
            new ValidityPeriod(5, DocumentType::$list)
        ];

        $documentType = "passport";

        $notExpired = new NotExpired([
            'today' => $today,
            'periods' => $periods,
            'documentType' => $documentType,
        ]);

        $this->assertEquals($periods, $notExpired->periods);
        $this->assertEquals($today, $notExpired->today);
        $this->assertEquals($documentType, $notExpired->documentType);
    }
}
