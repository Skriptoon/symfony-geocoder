<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
readonly class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Поле адрес не может быть пустым')]
    private string $address;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Некорректный или не точный адрес')]
    private string $coordinate;

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCoordinate(): string
    {
        return $this->coordinate;
    }

    /**
     * @param string $coordinate
     */
    public function setCoordinate(string $coordinate): void
    {
        $this->coordinate = $coordinate;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}