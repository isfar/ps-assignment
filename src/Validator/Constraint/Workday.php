<?php

namespace App\Validator\Constraint;

use App\Document\Weekdays;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

class Workday extends Constraint
{
    public $message = '{{ message }}';

    public $workdays;

    public function __construct(?array $options = null)
    {
        if (
            is_array($options)
            && array_key_exists('workdays', $options)
            && !is_array($options['workdays'])
        ) {
            throw new InvalidOptionsException('The option "workdays" is not an array', $options);
        }

        foreach ($options['workdays'] as $key => $workdays) {
            if (!$workdays instanceof Weekdays) {
                throw new InvalidOptionsException('The element at #' . $key . '("workdays") option is not an instance of "' . Weekdays::class . '".', $options);
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
            'workdays'
        ];
    }
}
