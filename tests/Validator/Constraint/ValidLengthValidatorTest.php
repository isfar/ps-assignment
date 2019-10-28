<?php

namespace App\Tests\Validator\Constraint;

use App\Document\DocumentType;
use App\Document\Length;
use App\Validator\Constraint\ValidLength;
use App\Validator\Constraint\ValidLengthValidator;
use ReflectionMethod;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class ValidLengthValidatorTest extends ConstraintValidatorTestCase
{

    public function createValidator()
    {
        return new ValidLengthValidator();
    }

    /**
     * @dataProvider provideValidateData
     */
    public function testValidate(
        $length,
        $lengths,
        $issueDate,
        $violates
    ) {
        $this->validator->validate($length, new ValidLength([
            'issueDate' => $issueDate,
            'lengths' => $lengths,
            'documentType' => DocumentType::IDENTITY_CARD,
        ]));


        if (!$violates) {
            $this->assertNoViolation();
        } else {
            $this
                ->buildViolation('{{ message }}')
                ->setParameter('{{ message }}', "document_number_length_invalid")
                ->assertRaised();
        }
    }

    public function provideValidateData()
    {
        return [
            [
                '123456',
                [
                    new Length(6),
                ],
                '2010-02-01',
                false
            ],
            [
                '123456',
                [
                    new Length(8, null, '2010-02-01'),
                    new Length(6, null, null, '2010-01-30'),
                ],
                '2010-02-01',
                true
            ],
            [
                '12345678',
                [
                    new Length(8, null, '2010-02-01'),
                    new Length(6, null, null, '2010-01-30'),
                ],
                '2010-02-01',
                false
            ],
        ];
    }

    /**
     * @dataProvider provideIsValidData
     */
    public function testIsValid(
        $length,
        $documentType,
        $lengths,
        $issueDate,
        $expected
    ) {
        $isValidReflection  = new ReflectionMethod(ValidLengthValidator::class, 'isValid');
        $isValidReflection->setAccessible(true);

        $validLengthValidator = new ValidLengthValidator();

        $output = $isValidReflection->invokeArgs($validLengthValidator, [
            $length,
            $documentType,
            $issueDate,
            $lengths
        ]);

        $this->assertEquals($expected, $output);
    }

    public function provideIsValidData()
    {
        return [
            [
                6,
                DocumentType::PASSPORT,
                [
                    new Length(6),
                ],
                '2010-02-01',
                true
            ],
            [
                6,
                DocumentType::PASSPORT,
                [
                    new Length(6, null, null, '2010-01-30'),
                    new Length(8, null, '2010-02-01'),
                ],
                '2010-02-01',
                false
            ],
            [
                8,
                DocumentType::PASSPORT,
                [
                    new Length(6, null, null, '2010-01-30'),
                    new Length(8, null, '2010-02-01'),
                ],
                '2010-02-01',
                true
            ],
            [
                6,
                DocumentType::PASSPORT,
                [
                    new Length(8, null, '2010-02-01'),
                    new Length(6, null, null, '2010-01-30'),
                ],
                '2010-02-01',
                false
            ],
            [
                8,
                DocumentType::PASSPORT,
                [
                    new Length(8, null, '2010-02-01'),
                    new Length(6, null, null, '2010-01-30'),
                ],
                '2010-02-01',
                true
            ],
            [
                12,
                DocumentType::PASSPORT,
                [
                    new Length(12, [ DocumentType::PASSPORT], '2014-01-01'),
                    new Length(6, null, null, '2010-01-30'),
                ],
                '2015-02-01',
                true
            ],
        ];
    }
}
