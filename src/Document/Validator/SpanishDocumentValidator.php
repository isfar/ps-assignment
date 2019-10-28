<?php
namespace App\Document\Validator;

use App\Document\Blacklist;
use App\Document\DocumentType;
use App\Document\ValidityPeriod;
use App\Storage\StorageInterface;

class SpanishDocumentValidator extends AbstractDocumentValidator
{
    public function __construct(
        StorageInterface $storage
    ) {
        parent::__construct($storage);

        parent::setValidityPeriods(array_merge(parent::getValidityPeriods(), [
            new ValidityPeriod(15, [ DocumentType::PASSPORT ], '2013-02-14'),
        ]));

        parent::setBlacklists([
            new Blacklist([ DocumentType::PASSPORT ], '50001111', '50009999'),
        ]);
    }
}
