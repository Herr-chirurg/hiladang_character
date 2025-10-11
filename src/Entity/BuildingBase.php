<?php

namespace App\Entity;

use App\Repository\BuildingBaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BuildingBaseRepository::class)]
class BuildingBase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0, nullable: true)]
    private ?string $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0, nullable: true)]
    private ?string $production = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bonus = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'upgrade_from')]
    private Collection $upgrade_to;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'upgrade_to')]
    private Collection $upgrade_from;

    /**
     * @var Collection<int, Building>
     */
    #[ORM\OneToMany(targetEntity: Building::class, mappedBy: 'base')]
    private Collection $buildings;

    public function __construct()
    {
        $this->upgrade_to = new ArrayCollection();
        $this->upgrade_from = new ArrayCollection();
        $this->buildings = new ArrayCollection();
    }

    static function CreateFromNameTypePriceProductionBonus(?string $name, ?string $type, ?string $price, ?string $production, ?string $bonus)
    {
        $buildingBase = new BuildingBase;

        return $buildingBase
            ->setName($name)
            ->setType($type)
            ->setPrice($price)
            ->setProduction($production)
            ->setBonus($bonus);

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getProduction(): ?string
    {
        return $this->production;
    }

    public function setProduction(?string $production): static
    {
        $this->production = $production;

        return $this;
    }

    public function getBonus(): ?string
    {
        return $this->bonus;
    }

    public function setBonus(?string $bonus): static
    {
        $this->bonus = $bonus;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getUpgradeTo(): Collection
    {
        return $this->upgrade_to;
    }

    public function addUpgradeTo(self $upgradeTo): static
    {
        if (!$this->upgrade_to->contains($upgradeTo)) {
            $this->upgrade_to->add($upgradeTo);
        }

        return $this;
    }

    public function removeUpgradeTo(self $upgradeTo): static
    {
        $this->upgrade_to->removeElement($upgradeTo);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getUpgradeFrom(): Collection
    {
        return $this->upgrade_from;
    }

    public function addUpgradeFrom(self $upgradeFrom): static
    {
        if (!$this->upgrade_from->contains($upgradeFrom)) {
            $this->upgrade_from->add($upgradeFrom);
            $upgradeFrom->addUpgradeTo($this);
        }

        return $this;
    }

    public function removeUpgradeFrom(self $upgradeFrom): static
    {
        if ($this->upgrade_from->removeElement($upgradeFrom)) {
            $upgradeFrom->removeUpgradeTo($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Building>
     */
    public function getBuildings(): Collection
    {
        return $this->buildings;
    }

    public function addBuilding(Building $building): static
    {
        if (!$this->buildings->contains($building)) {
            $this->buildings->add($building);
            $building->setBase($this);
        }

        return $this;
    }

    public function removeBuilding(Building $building): static
    {
        if ($this->buildings->removeElement($building)) {
            // set the owning side to null (unless already changed)
            if ($building->getBase() === $this) {
                $building->setBase(null);
            }
        }

        return $this;
    }
}
