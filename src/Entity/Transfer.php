<?php

namespace App\Entity;

use App\Repository\TransferRepository;
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

    #[ORM\ManyToOne(inversedBy: 'transfers_initiator')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Character $initiator = null;

    #[ORM\ManyToOne(inversedBy: 'transfers_recipient')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Character $recipient = null;

    #[ORM\Column(length: 1000)]
    private ?string $description = null;

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

    public function getInitiator(): ?Character
    {
        return $this->initiator;
    }

    public function setInitiator(?Character $initiator): static
    {
        $this->initiator = $initiator;

        return $this;
    }

    public function getRecipient(): Character
    {
        return $this->recipient;
    }

    public function setRecipient(?Character $recipient): static
    {
        $this->recipient = $recipient;

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
}
