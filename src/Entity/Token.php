<?php

namespace App\Entity;

use App\Repository\TokenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
class Token
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $type = null;

    #[ORM\Column(nullable: false)]
    private ?int $usage_rate = null;

    #[ORM\Column(nullable: true)]
    private ?int $delta_pr = null;

    #[ORM\ManyToOne(inversedBy: 'tokens')]
    private ?Scenario $scenario = null;

    #[ORM\ManyToOne(inversedBy: 'tokens')]
    private ?Character $character = null;

    #[ORM\Column]
    private ?\DateTime $date_of_reception = null;

    #[ORM\ManyToOne(inversedBy: 'tokens')]
    private ?User $owner_user = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0, nullable: true)]
    private ?string $totalRate = null;

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

    public function getUsageRate(): ?int
    {
        return $this->usage_rate;
    }

    public function setUsageRate(int $usage_rate): static
    {
        $this->usage_rate = $usage_rate;

        return $this;
    }

    public function getDeltaPr(): ?int
    {
        return $this->delta_pr;
    }

    public function setDeltaPr(int $delta_pr): static
    {
        $this->delta_pr = $delta_pr;

        return $this;
    }

    public function getScenario(): ?Scenario
    {
        return $this->scenario;
    }

    public function setScenario(?Scenario $scenario): static
    {
        $this->scenario = $scenario;

        return $this;
    }

    public function getCharacter(): ?Character
    {
        return $this->character;
    }

    public function setCharacter(?Character $character): static
    {
        $this->character = $character;

        return $this;
    }

    public function getDateOfReception(): ?\DateTime
    {
        return $this->date_of_reception;
    }

    public function setDateOfReception(\DateTime $date_of_reception): static
    {
        $this->date_of_reception = $date_of_reception;

        return $this;
    }

    public function getOwnerUser(): ?User
    {
        return $this->owner_user;
    }

    public function setOwnerUser(?User $owner_user): static
    {
        $this->owner_user = $owner_user;

        return $this;
    }

    public function getTotalRate(): ?string
    {
        return $this->totalRate;
    }

    public function setTotalRate(string $totalRate): static
    {
        $this->totalRate = $totalRate;

        return $this;
    }
}
