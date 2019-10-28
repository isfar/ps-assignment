<?php

namespace App\Validator\Constraint;

use App\Document\Length;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

class ValidLength extends Constraint
{
    public $message = '{{ message }}';

    public $lengths;

    public $issueDate;

    public $documentType;

    public function __construct(array $options = null)
    {
        if (
            is_array($options)
            && array_key_exists('lengths', $options)
            && !is_array($options['lengths'])
        ) {
            throw new InvalidOptionsException('The option "lengths" is not an array', $options);
        }

        foreach ($options['lengths'] as $key => $type) {
            if (!$type instanceof Length) {
                throw new InvalidOptionsException('The element at #' . $key . '("lengths") option is not an instance of "' . Length::class . '".', $options);
            }
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
            'lengths',
            'issueDate',
            'documentType'
        ];
    }
}
