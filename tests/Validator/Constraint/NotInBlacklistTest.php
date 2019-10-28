<?php

namespace App\Tests\Validator\Constraint;

use App\Document\DocumentType;
use App\Validator\Constraint\NotInBlacklist;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

class NotInBlacklistTest extends TestCase
{
    public function testInvalidOptionsTriggersException()
    {
        $this->expectException(InvalidOptionsException::class);

        new NotInBlacklist([
            'blacklists' => "Not an array",
            'documentType' => DocumentType::PASSPORT,
        ]);

    }

    public function testInvalidBlacklistsTriggersException()
    {
        $this->expectException(InvalidOptionsException::class);

        new NotInBlacklist([
            'blacklists' => [
                'Not an instance of Blacklist'
            ],
            'documentType' => DocumentType::PASSPORT,
        ]);
    }

    public function testOptionsCanBeSet()
    {
        $blacklists = [];

        $Blacklist = new NotInBlacklist([
            'blacklists' => [],
            'documentType' => DocumentType::PASSPORT,
        ]);

        $this->assertEquals($blacklists, $Blacklist->blacklists);
    }
}