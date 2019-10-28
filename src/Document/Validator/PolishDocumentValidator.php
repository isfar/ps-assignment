<?php
namespace App\Document\Validator;

use App\Document\DocumentType;
use App\Document\Length;
use App\Storage\StorageInterface;

class PolishDocumentValidator extends AbstractDocumentValidator
{
    public function __construct(
        StorageInterface $storage
    ) {
        parent::__construct($storage);

        parent::setDocumentTypes([
            new DocumentType(DocumentType::IDENTITY_CARD),
            new DocumentType(DocumentType::PASSPORT),
            new DocumentType(DocumentType::RESIDENCE_PERMIT, '2015-06-01'),
        ]);

        parent::setIdLengths([
            new Length(8, [
                DocumentType::PASSPORT,
                DocumentType::RESIDENCE_PERMIT,
            ]),
            new Length(8, [ DocumentType::IDENTITY_CARD ], null, '2018-08-31'),
            new Length(10, [ DocumentType::IDENTITY_CARD ], '2018-09-01')
        ]);
    }
}
