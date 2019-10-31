<?php

namespace App\DependencyInjection\Compiler;

use App\Document\Validator\Config;
use App\Document\Validator\ConfigFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class DocumentValidatorConfigPass implements CompilerPassInterface
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
                ->addTag('app.document_validator.config')
                ;

            $container->setDefinition("document_validators.{$countryCode}.config", $definition);
        }
    }
}
