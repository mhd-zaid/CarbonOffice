<?php

namespace App\Entity;

use App\Repository\RewardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RewardRepository::class)]
class Reward
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $level = 0;

    #[ORM\ManyToOne(inversedBy: 'rewards')]
    private ?Dispense $dispense = null;

    #[ORM\OneToOne(inversedBy: 'reward', cascade: ['persist', 'remove'])]
    private ?User $consultant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDispense(): ?Dispense
    {
        return $this->dispense;
    }

    public function setDispense(?Dispense $dispense): static
    {
        $this->dispense = $dispense;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): void
    {
        $this->level = $level;
    }

    public function getConsultant(): ?User
    {
        return $this->consultant;
    }

    public function setConsultant(?User $consultant): static
    {
        $this->consultant = $consultant;

        return $this;
    }

}
