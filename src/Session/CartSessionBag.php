<?php

namespace Bits\MmShopBundle\Session;

use Symfony\Component\HttpFoundation\Session\SessionBagInterface;

class CartSessionBag implements SessionBagInterface
{
    private string $name = 'cart';
    private array $data = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function initialize(array &$array): void
    {
        $this->data = &$array;
    }

    public function getStorageKey(): string
    {
        return '_cart'; // So heißt der Key im $_SESSION-Array
    }

    public function clear(): array
    {
        $cleared = $this->data;
        $this->data = [];

        return $cleared;
    }

    // Convenience methods
    public function set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function all(): array
    {
        return $this->data;
    }

    public function remove(string $key): void
    {
        unset($this->data[$key]);
    }
}
