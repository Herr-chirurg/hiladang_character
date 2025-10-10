<?php

namespace App\Entity;

use App\Repository\LogRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogRepository::class)]
class Log
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $item_type = null;

    #[ORM\Column]
    private ?int $item_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 255)]
    private ?string $field_name = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $old_value = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $new_value = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?string $user_id = null;

    public static function create(
        string $itemType,
        int $itemId,
        string $fieldName,
        string $description,
        ?string $oldValue = null,
        ?string $newValue = null,
        ?string $userId = null ): Log {
        // 1. Instanciation de l'objet
        $log = new Log();
        
        // 2. Initialisation des champs
        $log->setItemType($itemType);
        $log->setItemId($itemId);
        $log->setFieldName($fieldName);
        $log->setDescription($description);
        
        // 3. Initialisation des champs optionnels/variables
        $log->setOldValue($oldValue);
        $log->setNewValue($newValue);
        $log->setUserId($userId);
        
        // 4. Gestion de la date de création (obligatoire mais initialisée à "now" si null)
        $log->setCreatedAt($createdAt ?? new DateTimeImmutable()); 

        return $log;
    }

    public function __construct() {
        $this->setCreatedAt($createdAt ?? new DateTimeImmutable()); 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemType(): ?string
    {
        return $this->item_type;
    }

    public function setItemType(string $item_type): static
    {
        $this->item_type = $item_type;

        return $this;
    }

    public function getItemId(): ?int
    {
        return $this->item_id;
    }

    public function setItemId(int $item_id): static
    {
        $this->item_id = $item_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getFieldName(): ?string
    {
        return $this->field_name;
    }

    public function setFieldName(string $field_name): static
    {
        $this->field_name = $field_name;

        return $this;
    }

    public function getOldValue(): ?string
    {
        return $this->old_value;
    }

    public function setOldValue(?string $old_value): static
    {
        $this->old_value = $old_value;

        return $this;
    }

    public function getNewValue(): ?string
    {
        return $this->new_value;
    }

    public function setNewValue(?string $new_value): static
    {
        $this->new_value = $new_value;

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

    public function getUserId(): ?string
    {
        return $this->user_id;
    }

    public function setUserId(?string $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }
}
