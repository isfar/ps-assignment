<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class NotInRange extends Constraint
{
    public $message = '{{ message }}';

    public $min;

    public $max;

    public function validatedBy()
    {
        return self::class . 'Validator';
    }

    public function getRequiredOptions()
    {
        return [
            'min',
            'max'
        ];
    }
}
