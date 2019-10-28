<?php

namespace App\Tests\Validator\Constraint;

use App\Document\Blacklist;
use App\Document\DocumentType;
use App\Validator\Constraint\NotInBlacklistValidator;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class NotInBlacklistValidatorTest extends TestCase
{
    /**
     * @dataProvider provideIsBlacklistedData
     */
    public function testIsBlacklisted(
        $documentId,
        $documentType,
        $blacklists,
        $expected
    )
    {

        $isBlacklistedReflection = new ReflectionMethod(NotInBlacklistValidator::class, 'isBlacklisted');
        $isBlacklistedReflection->setAccessible(true);

        $notInBlacklistValidator = new NotInBlacklistValidator();

        $output = $isBlacklistedReflection->invokeArgs($notInBlacklistValidator, [
            $documentId,
            $documentType,
            $blacklists
        ]);

        $this->assertEquals($expected, $output);
    }

    public function provideIsBlacklistedData()
    {
        return [
            [
                '111111',
                DocumentType::PASSPORT,
                [
                    new Blacklist([]),
                    new Blacklist(
                        [ DocumentType::PASSPORT ],
                        '111111',
                        '200000'
                    ),
                ],
                true
            ],
            [
                '111111',
                DocumentType::RESIDENCE_PERMIT,
                [
                    new Blacklist([]),
                    new Blacklist(
                        [ DocumentType::PASSPORT ],
                        '111111',
                        '200000'
                    ),
                ],
                false
            ],
            [
                '111111',
                DocumentType::RESIDENCE_PERMIT,
                [
                    new Blacklist(
                        [ DocumentType::PASSPORT, DocumentType::RESIDENCE_PERMIT ],
                        '111111'
                    ),
                    new Blacklist([]),
                ],
                true
            ],
            [
                '111111',
                DocumentType::RESIDENCE_PERMIT,
                [],
                false
            ],
        ];
    }
}
