<?php

namespace App\Entity;

use App\Repository\ParticipationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipationsRepository::class)]
class Participations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #Relation mentorId n - n participation
    private ?int $mentorId = null;

    #[ORM\Column]
    #Relation userId n - n participation
    private ?int $userId = null;

    #[ORM\Column]
    #Relation dispenseId n - n participation
    private ?int $dispenseId = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

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

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getDispenseId(): ?int
    {
        return $this->dispenseId;
    }

    public function setDispenseId(int $dispenseId): self
    {
        $this->dispenseId = $dispenseId;

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
}
