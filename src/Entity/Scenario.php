<?php

namespace App\Entity;

use App\Repository\ScenarioRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScenarioRepository::class)]
class Scenario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 2, scale: 0)]
    private ?string $level = null;

    #[ORM\Column]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 1000)]
    private ?string $description = null;

    #[ORM\Column(type: Types::BLOB)]
    private $img;

    #[ORM\Column(length: 255)]
    private ?string $post_link = null;

    #[ORM\Column(length: 255)]
    private ?string $summary_link = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'scenarios')]
    private ?User $game_master = null;

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

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg($img): static
    {
        $this->img = $img;

        return $this;
    }

    public function getPostLink(): ?string
    {
        return $this->post_link;
    }

    public function setPostLink(string $post_link): static
    {
        $this->post_link = $post_link;

        return $this;
    }

    public function getSummaryLink(): ?string
    {
        return $this->summary_link;
    }

    public function setSummaryLink(string $summary_link): static
    {
        $this->summary_link = $summary_link;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getGameMaster(): ?User
    {
        return $this->game_master;
    }

    public function setGameMaster(?User $game_master): static
    {
        $this->game_master = $game_master;

        return $this;
    }
}
