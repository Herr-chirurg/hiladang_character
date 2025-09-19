<?php

namespace App\Entity;

use App\Repository\TokenRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
class Token
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $usage_rate = null;

    #[ORM\Column]
    private ?int $value = null;

    #[ORM\Column]
    private ?int $value_pr = null;

    #[ORM\ManyToOne(inversedBy: 'tokens')]
    private ?Scenario $scenario = null;

    #[ORM\ManyToOne(inversedBy: 'tokens')]
    private ?Character $character = null;

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

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValuePr(): ?int
    {
        return $this->value_pr;
    }

    public function setValuePr(int $value_pr): static
    {
        $this->value_pr = $value_pr;

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
}
