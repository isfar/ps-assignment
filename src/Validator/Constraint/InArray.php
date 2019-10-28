<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class InArray extends Constraint
{
    public $message = '{{ message }}';
    public $array;

    public function __construct(?array $options = null)
    {
        if (is_array($options) && array_key_exists('array', $options) && !is_array($options['array'])) {
            throw new InvalidArgumentException('The "array" parameter is not an array');
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
            'array'
        ];
    }
}
