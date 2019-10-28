<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class NotTooManyAttempt extends Constraint
{
    public $message = '{{ message }}';

    public $maxAllowed;

    public $numWorkdays;

    public $workdays;

    public $today;

    public $storage;

    public function validatedBy()
    {
        return self::class . 'Validator';
    }

    public function getRequiredOptions()
    {
        return [
            'today',
            'maxAllowed',
            'numWorkdays',
            'workdays',
            'storage',
        ];
    }
}