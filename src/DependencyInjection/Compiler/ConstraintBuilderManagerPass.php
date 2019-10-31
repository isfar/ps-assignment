<?php

namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ConstraintBuilderManagerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $managerDefinitionId = 'app.document.constraint_builder_manager';

        if (!$container->has($managerDefinitionId)) {
            return;
        }

        $definition = $container->findDefinition($managerDefinitionId);

        $taggedServices = $container->findTaggedServiceIds('app.document.constraint_builder');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('register', [
                explode('.', $id)[3],
                new Reference($id)
            ]);
        }
    }
}
