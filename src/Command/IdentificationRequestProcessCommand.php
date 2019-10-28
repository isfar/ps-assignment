<?php

namespace App\Command;

use App\Document\Document;
use App\Document\Validator\DocumentValidatorManager;
use App\Storage\StorageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validation;

class IdentificationRequestProcessCommand extends Command
{
    protected static $defaultName = 'identification-requests:process';

    /** @var StorageInterface */
    private $storage;

    /** @var DocumentValidatorManager */
    private $documentValidators;

    /** @var string */
    private $inputCsvPath;

    public function __construct(
        StorageInterface $storage,
        DocumentValidatorManager $documentValidators,
        string $inputCsvPath
    ) {
        parent::__construct();

        $this->storage = $storage;
        $this->documentValidators = $documentValidators;
        $this->inputCsvPath = $inputCsvPath;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $csv = array_map('str_getcsv', file($this->inputCsvPath));

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

            $documentValidator = $this->documentValidators->get($document->getCountryCode());

            $violations = $documentValidator->validate($document, $validator);

            $this->storage->add($document->getOwnerId(), $document->getRequestDate());

            if (count($violations)) {
                $io->writeln(
                    implode(', ', array_map(
                        function ($violation) {
                            return $violation->getMessage();
                        },
                        iterator_to_array($violations)
                    ))
                );
            } else {
                $io->writeln("valid");
            }
        }

        $io->success("Sucessfully validated records in the file '{$this->inputCsvPath}'.");
    }
}
