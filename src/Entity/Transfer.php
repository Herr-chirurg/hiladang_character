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
}
