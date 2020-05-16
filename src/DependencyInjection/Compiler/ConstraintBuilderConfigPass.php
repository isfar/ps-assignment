<?php

namespace App\DependencyInjection\Compiler;

use App\Document\Validator\Config;
use App\Document\Validator\ConfigFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ConstraintBuilderConfigPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->getParameterBag()->resolve();

        $countryCodes = $container->getParameter('document_validators.active_validators');

        foreach ($countryCodes as $countryCode) {
            $definition = new Definition(Config::class, [
                "%document_validators.{$countryCode}%"
            ]);

            $definition
                ->setFactory([
                    ConfigFactory::class,
                    'create'
                ])
                ->addTag('app.document.constraint_builder.config')
                ;

            $container->setDefinition("app.document.constraint_builder.{$countryCode}.config", $definition);
        }
    }
}
