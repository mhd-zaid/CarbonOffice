<?php

namespace App\Entity;

use App\Repository\DispenseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DispenseRepository::class)]
class Dispense
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #Relation mentorId n-n dispense
    private ?int $mentorId = null;

    #[ORM\Column]
    #Relation formationId n-n dispense
    private ?int $formationId = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMentorId(): ?int
    {
        return $this->mentorId;
    }

    public function setMentorId(int $mentorId): self
    {
        $this->mentorId = $mentorId;

        return $this;
    }

    public function getFormationId(): ?int
    {
        return $this->formationId;
    }

    public function setFormationId(int $formationId): self
    {
        $this->formationId = $formationId;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
