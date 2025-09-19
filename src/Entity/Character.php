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

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::BLOB)]
    private $img;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 0)]
    private ?string $xp_current = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 0)]
    private ?string $xp_current_mj = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $gp = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $pr = null;

    #[ORM\Column]
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

    /**
     * @var Collection<int, Transfer>
     */
    #[ORM\OneToMany(targetEntity: Transfer::class, mappedBy: 'initiator')]
    private Collection $transfers_initiator;

    /**
     * @var Collection<int, Transfer>
     */
    #[ORM\OneToMany(targetEntity: Transfer::class, mappedBy: 'recipient')]
    private Collection $transfers_recipient;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    private ?User $owner = null;

    /**
     * @var Collection<int, Token>
     */
    #[ORM\OneToMany(targetEntity: Token::class, mappedBy: 'character')]
    private Collection $tokens;

    public function __construct()
    {
        $this->buildings = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->transfers_initiator = new ArrayCollection();
        $this->transfers_recipient = new ArrayCollection();
        $this->tokens = new ArrayCollection();
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

    /**
     * @return Collection<int, Transfer>
     */
    public function getTransfersInitiator(): Collection
    {
        return $this->transfers_initiator;
    }

    public function addTransfersInitiator(Transfer $transfersInitiator): static
    {
        if (!$this->transfers_initiator->contains($transfersInitiator)) {
            $this->transfers_initiator->add($transfersInitiator);
            $transfersInitiator->setInitiator($this);
        }

        return $this;
    }

    public function removeTransfersInitiator(Transfer $transfersInitiator): static
    {
        if ($this->transfers_initiator->removeElement($transfersInitiator)) {
            // set the owning side to null (unless already changed)
            if ($transfersInitiator->getInitiator() === $this) {
                $transfersInitiator->setInitiator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transfer>
     */
    public function getTransfersRecipient(): Collection
    {
        return $this->transfers_recipient;
    }

    public function addTransfersRecipient(Transfer $transfersRecipient): static
    {
        if (!$this->transfers_recipient->contains($transfersRecipient)) {
            $this->transfers_recipient->add($transfersRecipient);
            $transfersRecipient->setRecipient($this);
        }

        return $this;
    }

    public function removeTransfersRecipient(Transfer $transfersRecipient): static
    {
        if ($this->transfers_recipient->removeElement($transfersRecipient)) {
            // set the owning side to null (unless already changed)
            if ($transfersRecipient->getRecipient() === $this) {
                $transfersRecipient->setRecipient(null);
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
}
