<?php

namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DocumentValidatorManagerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $managerDefinitionId = 'app.document_validator_manager';

        if (!$container->has($managerDefinitionId)) {
            return;
        }

        $definition = $container->findDefinition($managerDefinitionId);

        $taggedServices = $container->findTaggedServiceIds('app.document_validator');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('register', [
                explode('.', $id)[1],
                new Reference($id)
            ]);
        }
    }
}
