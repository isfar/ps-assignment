<?php

namespace App\Document\Validator;

use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Psr\Container\ContainerInterface;

class DocumentValidatorManagerFactory
{
    public static function create(
        ContainerInterface $container,
        array $config
    ) {
        $validators = new DocumentValidatorManager();


        foreach ($config as $alias => $service) {
            if (! $container->has($service)) {
                throw new ServiceNotFoundException(
                    "Constraint Provider (alias: $alias, service: $service) not found."
                );
            }

            $service = $container->get($service);

            $validators->register($alias, $service);
        }

        return $validators;
    }
}
