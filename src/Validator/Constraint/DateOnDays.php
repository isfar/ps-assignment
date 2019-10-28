<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class DateOnDays extends Constraint
{
    public $message = '{{ message }}';

    public $days;

    public function __construct(?array $options = null)
    {
        if (is_array($options) && array_key_exists('days', $options) && !is_array($options['days'])) {
            throw new InvalidArgumentException('The "days" parameter is not an array');
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
            'days'
        ];
    }
}
