<?php

namespace App\Storage;

class ArrayStorage implements StorageInterface
{
    private $store = [];

    public function add(string $key, string $value): self
    {
        if (! array_key_exists($key, $this->store)) {
            $this->store[$key] = [];
        }

        $this->store[$key][] = $value;
        return $this;
    }

    public function get(string $key): ?array
    {
        return array_key_exists($key, $this->store)
            ? $this->store[$key]
            : null;
    }

    public function getByOffset($key, ?int $offset): ?string
    {
        if (! array_key_exists($key, $this->store)) 
            return null;
        
        $offset = $offset >= 0
            ? $offset
            : count($this->store[$key]) + $offset;

        return array_key_exists($offset, $this->store[$key])
            ? $this->store[$key][$offset]
            : null;
    }
}

