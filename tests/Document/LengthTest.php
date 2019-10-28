<?php

namespace App\Tests\Document;

use App\Document\Length;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class LengthTest extends TestCase
{
    public function testParamtersCanBeSetThroughConstructor()
    {
        $length = 10;
        $documentTypes = [];
        $validFrom = '2010-01-01';
        $validTill = '2022-01-19';


        $objLength = new Length(
            $length,
            $documentTypes,
            $validFrom,
            $validTill
        );

        $lengthReflection = new ReflectionClass(Length::class);

        $documentTypesReflection = $lengthReflection->getProperty('documentTypes');
        $documentTypesReflection->setAccessible(true);

        $intLengthReflection = $lengthReflection->getProperty('length');
        $intLengthReflection->setAccessible(true);

        $validFromReflection = $lengthReflection->getProperty('validFrom');
        $validFromReflection->setAccessible(true);

        $validTillReflection = $lengthReflection->getProperty('validTill');
        $validTillReflection->setAccessible(true);

        $this->assertEquals($documentTypes, $documentTypesReflection->getValue($objLength));
        $this->assertEquals($length, $intLengthReflection->getValue($objLength));
        $this->assertEquals($validFrom, $validFromReflection->getValue($objLength));
        $this->assertEquals($validTill, $validTillReflection->getValue($objLength));
    }

    public function testGetters()
    {
        $length = 10;
        $documentTypes = [];
        $validFrom = '2010-01-01';
        $validTill = '2022-01-19';


        $objLength = new Length(
            $length,
            $documentTypes,
            $validFrom,
            $validTill
        );

        $this->assertEquals($length, $objLength->getLength());
        $this->assertEquals($documentTypes, $objLength->getDocumentTypes());
        $this->assertEquals($validFrom, $objLength->getValidFrom());
        $this->assertEquals($validTill, $objLength->getValidTill());
    }
}
