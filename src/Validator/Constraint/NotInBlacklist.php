<?php

namespace App\Validator\Constraint;

use App\Document\Blacklist;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

class NotInBlacklist extends Constraint
{
    public $message = '{{ message }}';

    public $blacklists;

    public $documentType;

    public function __construct(?array $options = null)
    {
        if (is_array($options)
            && array_key_exists('blacklists', $options)
            && !is_array($options['blacklists'])
        ) {
            throw new InvalidOptionsException('The option "blacklists" is not an array', $options);
        }

        foreach ($options['blacklists'] as $key => $blacklists) {
            if (!$blacklists instanceof Blacklist) {
                throw new InvalidOptionsException(
                    'The element at #' . $key . '("blacklists") option is not an instance of "'
                        . Blacklist::class . '".',
                    $options
                );
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
            'blacklists',
            'documentType',
        ];
    }
}
