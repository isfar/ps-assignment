<?php

namespace App\Tests\Validator\Constraint;

use App\Document\Blacklist;
use App\Document\DocumentType;
use App\Validator\Constraint\NotInBlacklist;
use App\Validator\Constraint\NotInBlacklistValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use ReflectionMethod;

class NotInBlacklistValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new NotInBlacklistValidator();
    }

    /**
     * @dataProvider provideValidateData
     */
    public function testValidate(
        $documentId,
        $documentType,
        $blacklists,
        $violates
    ) {
        $this->validator->validate($documentId, new NotInBlacklist([
            'documentType' => $documentType,
            'blacklists' => $blacklists,
        ]));


        if (!$violates) {
            $this->assertNoViolation();
        } else {
            $this
                ->buildViolation('{{ message }}')
                ->setParameter('{{ message }}', "document_number_invalid")
                ->assertRaised();
        }
    }

    public function provideValidateData()
    {
        $blacklists = [
            new Blacklist([
                DocumentType::PASSPORT
            ], '11111', '22222'),
        ];

        return [
            [
                '12345',
                DocumentType::PASSPORT,
                $blacklists,
                true
            ],
            [
                '22345',
                DocumentType::PASSPORT,
                $blacklists,
                false
            ],
        ];
    }

    /**
     * @dataProvider provideIsBlacklistedData
     */
    public function testIsBlacklisted(
        $documentId,
        $documentType,
        $blacklists,
        $expected
    ) {

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
