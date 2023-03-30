<?php

declare(strict_types=1);

namespace App\Entity;

class Address
{
    private string $name;
    private array $coordinate;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getCoordinate(): array
    {
        return $this->coordinate;
    }

    /**
     * @param array $coordinate
     */
    public function setCoordinate(array $coordinate): void
    {
        $this->coordinate = $coordinate;
    }
}