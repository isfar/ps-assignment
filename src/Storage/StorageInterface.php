<?php

namespace App\Storage;

interface StorageInterface
{
    public function add(string $key, string $value);
    public function get(string $key): ?array;
    public function getByOffset(string $key, int $offset): ?string;
}

