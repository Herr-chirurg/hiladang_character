<?php

namespace App\Entity;

use ApiPlatform\Metadata\GetCollection;
use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
    #[ApiResource(
        normalizationContext: ['groups' => ['owner:read']],
        stateless: false,
        operations: [
            // Permet l'affichage de la collection (GET /clients)
            new GetCollection(),
            // Permet l'affichage d'un seul élément (GET /clients/{id})
            new Get(),
        ],
    )]
class Character
{

    

    public const LEVEL_UP = "levelUp";
    public const PURCHASE = "purchase";
    public const EDIT = "edit";
    public const NEW = "new";
    public const DELETE = "delete";
    public const TRADE = "trade";
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['owner:read'])]
    #[ORM\Column(length: 255, nullable: false)]
    private ?string $name = null;

    #[Groups(['owner:read'])]
    #[ORM\Column(length: 255, nullable: false)]
    private ?string $title = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $img;

    #[Groups(['owner:read'])]
    #[ORM\Column(nullable: false)]
    private ?int $level = 3;

    #[Groups(['owner:read'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 0, nullable: false)]
    private ?string $xp_current = null;

    #[Groups(['owner:read'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 0, nullable: false)]
    private ?string $xp_current_mj = null;

    #[Groups(['owner:read'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: false)]
    private ?string $gp = null;

    #[Groups(['owner:read'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0, nullable: false)]
    private ?string $pr = null;

    #[Groups(['owner:read'])]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: false)]
    private ?\DateTime $end_activity = null;

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

    private ?Token $consumableToken = null;

    /**
     * @var Collection<int, Scenario>
     */
    #[ORM\ManyToMany(targetEntity: Scenario::class, mappedBy: 'characters')]
    private Collection $scenarios;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $last_action_description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $webhook_link = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $last_action = null;

    #[ORM\OneToOne(mappedBy: 'buyer', cascade: ['persist', 'remove'])]
    private ?CartGP $cartGP = null;

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

    public function getEndActivity(): ?\DateTime
    {
        return $this->end_activity;
    }

    public function setEndActivity(?\DateTime $end_activity): static
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

    public function setConsumableToken(?Token $token): static {
        $this->consumableToken = $token;

        return $this;
    }

    public function getConsumableToken(): ?Token {
        return $this->consumableToken;
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

    public function getWebhookLink(): ?string
    {
        return $this->webhook_link;
    }

    public function setWebhookLink(?string $webhook_link): static
    {
        $this->webhook_link = $webhook_link;

        return $this;
    }

    public function getLastAction(): ?string
    {
        return $this->last_action;
    }

    public function setLastAction(?string $last_action): static
    {
        $this->last_action = $last_action;

        return $this;
    }

    public function getCartGP(): ?CartGP
    {
        return $this->cartGP;
    }

    public function setCartGP(?CartGP $cartGP): static
    {
        // unset the owning side of the relation if necessary
        if ($cartGP === null && $this->cartGP !== null) {
            $this->cartGP->setBuyer(null);
        }

        // set the owning side of the relation if necessary
        if ($cartGP !== null && $cartGP->getBuyer() !== $this) {
            $cartGP->setBuyer($this);
        }

        $this->cartGP = $cartGP;

        return $this;
    }
}
