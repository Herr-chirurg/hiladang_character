<?php

namespace App\Entity;

use App\Repository\ScenarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: ScenarioRepository::class)]
    #[ApiResource(
        normalizationContext: ['groups' => ['owner:read']],
        stateless: false,
        operations: [
            new GetCollection(),
            new Get(),
        ],
    )]
class Scenario
{

    public const STATUS_CREATED = 'created';
    public const STATUS_AWARDED = 'awarded';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['owner:read'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['owner:read'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 2, scale: 0, nullable: false)]
    private ?string $level = null;

    #[Groups(['owner:read'])]
    #[ORM\Column(nullable: false)]
    private ?\DateTime $date = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $img;

    #[Groups(['owner:read'])]
    #[ORM\Column(length: 255, nullable: false)]
    private ?string $post_link = null;

    #[Groups(['owner:read'])]
    #[ORM\Column(length: 255, nullable: false)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'scenarios')]
    private ?User $game_master = null;

    #[Groups(['owner:read'])]
    #[SerializedName('gamemaster')]
    public function getGameMasterId(): ?int
    {
        return $this->game_master ? $this->game_master->getId() : null;
    }

    /**
     * @var Collection<int, Token>
     */
    #[ORM\OneToMany(targetEntity: Token::class, mappedBy: 'scenario')]
    private Collection $tokens;

    /**
     * @var Collection<int, Character>
     */
    #[ORM\ManyToMany(targetEntity: Character::class, inversedBy: 'scenarios')]
    private Collection $characters;

    #[Groups(['owner:read'])]
    #[ORM\Column(nullable: true)]
    private ?bool $editable = null;

    public function __construct()
    {
        $this->tokens = new ArrayCollection();
        $this->characters = new ArrayCollection();
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
            $token->setScenario($this);
        }

        return $this;
    }

    public function removeToken(Token $token): static
    {
        if ($this->tokens->removeElement($token)) {
            // set the owning side to null (unless already changed)
            if ($token->getScenario() === $this) {
                $token->setScenario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): static
    {
        if (!$this->characters->contains($character)) {
            $this->characters->add($character);
        }

        return $this;
    }

    public function removeCharacter(Character $character): static
    {
        $this->characters->removeElement($character);

        return $this;
    }

    public function isEditable(): ?bool
    {
        return $this->editable;
    }

    public function setEditable(?bool $editable): static
    {
        $this->editable = $editable;

        return $this;
    }

}