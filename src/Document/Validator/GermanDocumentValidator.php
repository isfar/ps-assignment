<?php
namespace App\Document\Validator;

use App\Document\DocumentType;
use App\Document\ValidityPeriod;
use App\Storage\StorageInterface;

class GermanDocumentValidator extends AbstractDocumentValidator
{
    public function __construct(
        StorageInterface $storage
    ) {
        parent::__construct($storage);

        parent::setValidityPeriods(array_merge(
            parent::getValidityPeriods(),
            [
                new ValidityPeriod(10, DocumentType::$list, '2010-01-01')
            ]
        ));
    }
}
