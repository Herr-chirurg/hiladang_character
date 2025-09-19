<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    /**
     * @var Collection<int, Character>
     */
    #[ORM\OneToMany(targetEntity: Character::class, mappedBy: 'buildings')]
    private Collection $Owner;

    public function __construct()
    {
        $this->Owner = new ArrayCollection();
    }

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getOwner(): Collection
    {
        return $this->Owner;
    }

    public function addOwner(Character $owner): static
    {
        if (!$this->Owner->contains($owner)) {
            $this->Owner->add($owner);
            $owner->setBuildings($this);
        }

        return $this;
    }

    public function removeOwner(Character $owner): static
    {
        if ($this->Owner->removeElement($owner)) {
            // set the owning side to null (unless already changed)
            if ($owner->getBuildings() === $this) {
                $owner->setBuildings(null);
            }
        }

        return $this;
    }
}
