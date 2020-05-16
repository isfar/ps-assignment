<?php

namespace App\Tests\Document;

use App\Document\Blacklist;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class BlacklistTest extends TestCase
{
    public function testParamtersCanBeSetThroughConstructor()
    {
        $documentTypes = [];
        $min = '11111';
        $max = '22222';

        $blacklist = new Blacklist(
            $documentTypes,
            $min,
            $max
        );

        $blacklistReflection = new ReflectionClass(Blacklist::class);

        $documentTypeReflection = $blacklistReflection->getProperty('documentTypes');
        $documentTypeReflection->setAccessible(true);

        $minReflection = $blacklistReflection->getProperty('min');
        $minReflection->setAccessible(true);

        $maxReflection = $blacklistReflection->getProperty('max');
        $maxReflection->setAccessible(true);

        $this->assertEquals($documentTypes, $documentTypeReflection->getValue($blacklist));
        $this->assertEquals($min, $minReflection->getValue($blacklist));
        $this->assertEquals($max, $maxReflection->getValue($blacklist));
    }

    public function testGetters()
    {
        $documentTypes = [];
        $min = '11111';
        $max = '22222';

        $blacklist = new Blacklist(
            $documentTypes,
            $min,
            $max
        );

        $this->assertEquals($documentTypes, $blacklist->getDocumentTypes());
        $this->assertEquals($min, $blacklist->getMin());
        $this->assertEquals($max, $blacklist->getMax());
    }
}
