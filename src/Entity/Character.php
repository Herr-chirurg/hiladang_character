<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $img;

    #[ORM\Column(nullable: true)]
    private ?int $level = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 0, nullable: true)]
    private ?string $xp_current = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 0, nullable: true)]
    private ?string $xp_current_mj = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $gp = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0, nullable: true)]
    private ?string $pr = null;

    #[ORM\Column(nullable: true)]
    private ?int $end_activity = null;

    /**
     * @var Collection<int, Building>
     */
    #[ORM\OneToMany(targetEntity: Building::class, mappedBy: 'owner')]
    private Collection $buildings;

    /**
     * @var Collection<int, Activity>
     */
    #[ORM\OneToMany(targetEntity: Activity::class, mappedBy: 'participant')]
    private Collection $activities;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    private ?User $owner = null;

    /**
     * @var Collection<int, Token>
     */
    #[ORM\OneToMany(targetEntity: Token::class, mappedBy: 'character')]
    private Collection $tokens;

    /**
     * @var Collection<int, Scenario>
     */
    #[ORM\ManyToMany(targetEntity: Scenario::class, mappedBy: 'characters')]
    private Collection $scenarios;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $last_action_description = null;

    public function __construct()
    {
        $this->buildings = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->tokens = new ArrayCollection();
        $this->scenarios = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getXpCurrent(): ?string
    {
        return $this->xp_current;
    }

    public function setXpCurrent(string $xp_current): static
    {
        $this->xp_current = $xp_current;

        return $this;
    }

    public function getXpCurrentMj(): ?string
    {
        return $this->xp_current_mj;
    }

    public function setXpCurrentMj(string $xp_current_mj): static
    {
        $this->xp_current_mj = $xp_current_mj;

        return $this;
    }

    public function getGp(): ?string
    {
        return $this->gp;
    }

    public function setGp(string $gp): static
    {
        $this->gp = $gp;

        return $this;
    }

    public function getPr(): ?string
    {
        return $this->pr;
    }

    public function setPr(string $pr): static
    {
        $this->pr = $pr;

        return $this;
    }

    public function getEndActivity(): ?int
    {
        return $this->end_activity;
    }

    public function setEndActivity(int $end_activity): static
    {
        $this->end_activity = $end_activity;

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
            $building->setOwner($this);
        }

        return $this;
    }

    public function removeBuilding(Building $building): static
    {
        if ($this->buildings->removeElement($building)) {
            // set the owning side to null (unless already changed)
            if ($building->getOwner() === $this) {
                $building->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): static
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
            $activity->setParticipant($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getParticipant() === $this) {
                $activity->setParticipant(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Token>
     */
    public function getTokens(): Collection
    {
        return $this->tokens;
    }

    public function addToken(Token $token): static
    {
        if (!$this->tokens->contains($token)) {
            $this->tokens->add($token);
            $token->setCharacter($this);
        }

        return $this;
    }

    public function removeToken(Token $token): static
    {
        if ($this->tokens->removeElement($token)) {
            // set the owning side to null (unless already changed)
            if ($token->getCharacter() === $this) {
                $token->setCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Scenario>
     */
    public function getScenarios(): Collection
    {
        return $this->scenarios;
    }

    public function addScenario(Scenario $scenario): static
    {
        if (!$this->scenarios->contains($scenario)) {
            $this->scenarios->add($scenario);
            $scenario->addCharacter($this);
        }

        return $this;
    }

    public function removeScenario(Scenario $scenario): static
    {
        if ($this->scenarios->removeElement($scenario)) {
            $scenario->removeCharacter($this);
        }

        return $this;
    }

    public function getLastActionDescription(): ?string
    {
        return $this->last_action_description;
    }

    public function setLastActionDescription(string $last_action_description): static
    {
        $this->last_action_description = $last_action_description;

        return $this;
    }
}
