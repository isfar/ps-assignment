<?php

namespace App\Document\Validator;

use App\Document\Weekdays;
use App\Storage\StorageInterface;
use App\Util\Day;

class ItalianDocumentValidator extends AbstractDocumentValidator
{
    public function __construct(
        StorageInterface $storage
    ) {
        parent::__construct($storage);    

        parent::setWorkdays(array_merge(parent::getWorkdays(), [
            new Weekdays([ Day::SAT ], '2019-01-01', '2019-01-31')
        ]));
    }
}
