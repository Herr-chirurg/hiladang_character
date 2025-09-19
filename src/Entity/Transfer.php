<?php

namespace App\Entity;

use App\Repository\TransferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransferRepository::class)]
class Transfer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $gp = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $pr = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $extra_pr = null;

    /**
     * @var Collection<int, Character>
     */
    #[ORM\OneToMany(targetEntity: Character::class, mappedBy: 'transfers_initiated')]
    private Collection $initiator;

    /**
     * @var Collection<int, Character>
     */
    #[ORM\OneToMany(targetEntity: Character::class, mappedBy: 'transfers_recipient')]
    private Collection $recipient;

    public function __construct()
    {
        $this->initiator = new ArrayCollection();
        $this->recipient = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getExtraPr(): ?string
    {
        return $this->extra_pr;
    }

    public function setExtraPr(string $extra_pr): static
    {
        $this->extra_pr = $extra_pr;

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getInitiator(): Collection
    {
        return $this->initiator;
    }

    public function addInitiator(Character $initiator): static
    {
        if (!$this->initiator->contains($initiator)) {
            $this->initiator->add($initiator);
            $initiator->setTransfersInitiated($this);
        }

        return $this;
    }

    public function removeInitiator(Character $initiator): static
    {
        if ($this->initiator->removeElement($initiator)) {
            // set the owning side to null (unless already changed)
            if ($initiator->getTransfersInitiated() === $this) {
                $initiator->setTransfersInitiated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getRecipient(): Collection
    {
        return $this->recipient;
    }

    public function addRecipient(Character $recipient): static
    {
        if (!$this->recipient->contains($recipient)) {
            $this->recipient->add($recipient);
            $recipient->setTransfersRecipient($this);
        }

        return $this;
    }

    public function removeRecipient(Character $recipient): static
    {
        if ($this->recipient->removeElement($recipient)) {
            // set the owning side to null (unless already changed)
            if ($recipient->getTransfersRecipient() === $this) {
                $recipient->setTransfersRecipient(null);
            }
        }

        return $this;
    }
}
