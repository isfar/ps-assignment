<?php

namespace App\Document\Validator;

use App\Document\Document;

interface ConstraintBuilderInterface
{
    public function build(Document $document);
}
