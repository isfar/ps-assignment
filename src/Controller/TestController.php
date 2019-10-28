<?php

namespace App\Controller;

use App\Document\Document;
use App\Document\Validator\DocumentValidatorManager;
use App\Storage\StorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(
        StorageInterface $storage,
        DocumentValidatorManager $documentValidators
    ) {
        $csv = array_map('str_getcsv', file(getcwd() . '/../data/input.csv'));

        $validator = Validation::createValidator();

        foreach ($csv as $i => $record) {
            $document = new Document(
                $record[3],
                $record[5],
                $record[2],
                $record[0],
                $record[4],
                $record[1]
            );


            $documentValidator = $documentValidators->get($document->getCountryCode());
            $violations = $documentValidator->validate($document, $validator);
            $storage->add($document->getOwnerId(), $document->getRequestDate());

            if (count($violations)) {
                echo implode(', ', array_map(function ($violation) {
                    return $violation->getMessage();
                }, iterator_to_array($violations))) . PHP_EOL;

            } else {
                echo "valid" . PHP_EOL;
            }
        }
        
        die();
    }
}
