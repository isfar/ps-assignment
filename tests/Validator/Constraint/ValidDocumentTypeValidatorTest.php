<?php

namespace App\Tests\Validator\Constraint;

use App\Document\DocumentType;
use App\Validator\Constraint\ValidDocumentType;
use App\Validator\Constraint\ValidDocumentTypeValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use ReflectionMethod;

class ValidDocumentTypeValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new ValidDocumentTypeValidator();
    }

    /**
     * @dataProvider provideValidateData
     */
    public function testValidate(
        $type,
        $issueDate,
        $types,
        $violates
    ) {
        $this->validator->validate($type, new ValidDocumentType([
            'issueDate' => $issueDate,
            'types' => $types,            
        ]));


        if (!$violates) {
            $this->assertNoViolation();
        } else {
            $this
                ->buildViolation('{{ message }}')
                ->setParameter('{{ message }}', "invalid_document_type")
                ->assertRaised();
        }
    }

    public function provideValidateData()
    {
        return [
            [
                DocumentType::PASSPORT,
                '2010-01-01',
                [
                    new DocumentType(DocumentType::PASSPORT),
                    new DocumentType(DocumentType::DRIVING_LICENSE),
                    new DocumentType(DocumentType::IDENTITY_CARD),
                ],
                false
            ],
            [
                DocumentType::RESIDENCE_PERMIT,
                '2010-01-01',
                [
                    new DocumentType(DocumentType::PASSPORT),
                    new DocumentType(DocumentType::DRIVING_LICENSE),
                    new DocumentType(DocumentType::IDENTITY_CARD),
                    new DocumentType(DocumentType::RESIDENCE_PERMIT, '2014-01-01'),
                ],
                true
            ],
            [
                DocumentType::RESIDENCE_PERMIT,
                '2015-01-01',
                [
                    new DocumentType(DocumentType::PASSPORT),
                    new DocumentType(DocumentType::DRIVING_LICENSE),
                    new DocumentType(DocumentType::IDENTITY_CARD),
                    new DocumentType(DocumentType::RESIDENCE_PERMIT, '2014-01-01'),
                ],
                false
            ],
        ];
    }

    /**
     * @dataProvider provideIsValidData
     */
    public function testIsValid(
        $documentType,
        $types,
        $issueDate,
        $expected
    ) {

        $validDocumentTypeValidator = new ValidDocumentTypeValidator();

        $isValidReflection = new ReflectionMethod(ValidDocumentTypeValidator::class, 'isValid');
        $isValidReflection->setAccessible(true);

        $output = $isValidReflection->invokeArgs($validDocumentTypeValidator, [
            $documentType,
            $issueDate,
            $types,
        ]);

        $this->assertEquals($expected, $output);
    }

    
    public function provideIsValidData()
    {
        return [
            [
                DocumentType::PASSPORT,
                [
                    new DocumentType(DocumentType::PASSPORT),
                ],
                '2014-01-01',
                true
            ],
            [
                DocumentType::PASSPORT,
                [
                    new DocumentType(DocumentType::IDENTITY_CARD),
                ],
                '2014-01-01',
                false
            ],
            [
                'passport',
                [
                    new DocumentType(DocumentType::IDENTITY_CARD),
                    new DocumentType(DocumentType::PASSPORT, '2016-01-01'),
                ],
                '2014-01-01',
                false
            ],
            [
                'passport',
                [
                    new DocumentType(DocumentType::IDENTITY_CARD),
                    new DocumentType(DocumentType::PASSPORT, '2016-01-01'),
                ],
                '2016-01-01',
                true
            ],
            [
                DocumentType::PASSPORT,
                [],
                '2016-01-01',
                false
            ],
        ];
    }
}