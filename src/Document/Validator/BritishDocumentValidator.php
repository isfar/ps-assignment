<?php
namespace App\Document\Validator;

use App\Document\DocumentType;
use App\Storage\StorageInterface;

class BritishDocumentValidator extends AbstractDocumentValidator
{
    public function __construct(
        StorageInterface $storage
    ) {
        parent::__construct($storage);

        parent::setDocumentTypes([
            new DocumentType(DocumentType::PASSPORT, '2019-01-01'),
        ]);
    }
}
