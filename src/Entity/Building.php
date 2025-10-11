<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BuildingRepository::class)]
class Building
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'buildings')]
    private ?Character $owner = null;

    #[ORM\ManyToOne(inversedBy: 'buildings')]
    private ?Location $location = null;

    #[ORM\ManyToOne(inversedBy: 'buildings')]
    private ?BuildingBase $base = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getOwner(): ?Character
    {
        return $this->owner;
    }

    public function setOwner(?Character $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getBase(): ?BuildingBase
    {
        return $this->base;
    }

    public function setBase(?BuildingBase $base): static
    {
        $this->base = $base;

        return $this;
    }
}
