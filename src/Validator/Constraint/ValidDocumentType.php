<?php

namespace App\Validator\Constraint;

use App\Document\DocumentType;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\InvalidOptionsException;
use App\Util\Date;

class ValidDocumentType extends Constraint
{
    public $message = '{{ message }}';

    public $types;

    public $issueDate;

    public function __construct(array $options = null)
    {
        if (is_array($options)
            && array_key_exists('types', $options)
            && !is_array($options['types'])
        ) {
            throw new InvalidOptionsException('The option "types" is not an array', $options);
        }

        foreach ($options['types'] as $key => $type) {
            if (!$type instanceof DocumentType) {
                throw new InvalidOptionsException(
                    'The element at #' . $key . '("types") option is not an instance of "' . DocumentType::class . '".',
                    $options
                );
            }
        }

        if (is_array($options)
            && array_key_exists('issueDate', $options)
            && !Date::isValid($options['issueDate'])
        ) {
            throw new InvalidOptionsException('Option "issueDate" is not in format "Y-m-d"', $options);
        }

        parent::__construct($options);
    }

    public function validatedBy()
    {
        return self::class . 'Validator';
    }

    public function getRequiredOptions()
    {
        return [
            'types',
            'issueDate'
        ];
    }
}
