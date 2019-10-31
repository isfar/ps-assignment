<?php

namespace App\DependencyInjection\Compiler;

use App\Document\Validator\DocumentValidator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class DocumentValidatorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->getParameterBag()->resolve();

        $countryCodes = $container->getParameter('document_validators.active_validators');

        foreach ($countryCodes as $countryCode) {
            $definition = new Definition(DocumentValidator::class, [
                new Reference('app.storage.array_storage'),
                new Reference("document_validators.{$countryCode}.config")
            ]);

            $definition->addTag('app.document_validator');

            $container->setDefinition("document_validators.{$countryCode}", $definition);
        }
    }
}
