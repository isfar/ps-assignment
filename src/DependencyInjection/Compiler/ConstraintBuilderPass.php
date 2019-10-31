<?php

namespace App\DependencyInjection\Compiler;

use App\Document\Validator\ConstraintBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ConstraintBuilderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->getParameterBag()->resolve();

        $countryCodes = $container->getParameter('document_validators.active_validators');

        foreach ($countryCodes as $countryCode) {
            $definition = new Definition(ConstraintBuilder::class, [
                new Reference('app.storage.array_storage'),
                new Reference("app.document.constraint_builder.{$countryCode}.config")
            ]);

            $definition->addTag('app.document.constraint_builder');

            $container->setDefinition("app.document.constraint_builder.{$countryCode}", $definition);
        }
    }
}
