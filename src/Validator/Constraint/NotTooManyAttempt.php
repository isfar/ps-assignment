<?php

namespace App\Validator\Constraint;

use App\Document\RequestLimit;
use App\Storage\StorageInterface;
use Symfony\Component\Validator\Constraint;
use App\Util\Date;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

class NotTooManyAttempt extends Constraint
{
    public $message = '{{ message }}';

    public $limit;

    public $today;

    public $storage;

    public function __construct(array $options)
    {
        if (is_array($options)
            && array_key_exists('today', $options)
            && !Date::isValid($options['today'])
        ) {
            throw new InvalidOptionsException('Option "today" is not in format "Y-m-d"', $options);
        }

        if (is_array($options)
            && array_key_exists('storage', $options)
            && !$options['storage'] instanceof StorageInterface
        ) {
            throw new InvalidOptionsException(
                'Option "storage" is not an instance of "' . StorageInterface::class . '"',
                $options
            );
        }

        if (is_array($options)
            && array_key_exists('limit', $options)
            && !$options['limit'] instanceof RequestLimit
        ) {
            throw new InvalidOptionsException(
                'Option "limit" is not an instance of "' . RequestLimit::class . '"',
                $options
            );
        }

        if (is_array($options)
            && array_key_exists('documentType', $options)
            && !in_array($options['documentType'], DocumentType::$list)
        ) {
            throw new InvalidOptionsException('Unknown document type.', $options);
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
            'storage',
            'limit',
        ];
    }
}
