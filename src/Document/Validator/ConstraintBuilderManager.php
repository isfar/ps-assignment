<?php

namespace App\Document\Validator;

use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class ConstraintBuilderManager
{
    private $services = [];

    public function register(string $key, ConstraintBuilderInterface $service): self
    {
        $this->services[$key] = $service;
        return $this;
    }

    public function get(string $key): ?ConstraintBuilderInterface
    {
        if (isset($this->services[$key]) && $this->services[$key] instanceof ConstraintBuilderInterface) {
            return $this->services[$key];
        }

        throw new ServiceNotFoundException("No ConstraintBuilder registered with the key: $key");
    }
}
