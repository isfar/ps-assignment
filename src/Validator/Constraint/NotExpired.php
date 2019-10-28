<?php

namespace App\Validator\Constraint;

use App\Document\DocumentType;
use App\Document\ValidityPeriod;
use App\Util\Date;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

class NotExpired extends Constraint
{
    /** @var string */
    public $message = '{{ message }}';

    /** @var ValidityPeriod */
    public $periods;

    /** @var string */
    public $today;

    /** @var string */
    public $documentType;

    public function __construct(array $options)
    {
        if (is_array($options)
            && array_key_exists('today', $options)
            && !Date::isValid($options['today'])
        ) {
            throw new InvalidOptionsException('Option "today" is not in format "Y-m-d"', $options);
        }

        if (is_array($options)
            && array_key_exists('periods', $options)
            && !is_array($options['periods'])
        ) {
            throw new InvalidOptionsException('Option "periods" is not an array', $options);
        }

        foreach ($options['periods'] as $key => $validityPeriod) {
            if (!$validityPeriod instanceof ValidityPeriod) {
                throw new InvalidOptionsException(
                    'Element in "periods"#' . $key . ' is not an instance of "' . ValidityPeriod::class . '"',
                    $options
                );
            }
        }


        if (is_array($options)
            && array_key_exists('documentType', $options)
            && !in_array($options['documentType'], DocumentType::$list)
        ) {
            throw new InvalidOptionsException('Option "documentType" is not an string', $options);
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
            'today',
            'periods',
            'documentType',
        ];
    }
}
