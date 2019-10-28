<?php
namespace App\Document\Validator;

use App\Document\DocumentType;
use App\Storage\StorageInterface;

class FrenchDocumentValidator extends AbstractDocumentValidator
{
    public function __construct(
        StorageInterface $storage
    ) {
        parent::__construct($storage);

        parent::setDocumentTypes(array_merge(parent::getDocumentTypes(), [
            new DocumentType(DocumentType::DRIVING_LICENSE),
        ]));
    }
}
