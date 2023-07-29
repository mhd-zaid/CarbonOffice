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

    #[ORM\OneToOne(inversedBy: 'reward', cascade: ['persist', 'remove'])]
    private ?User $consultant = null;

    #[ORM\ManyToMany(targetEntity: Dispense::class, inversedBy: 'rewards')]
    private Collection $dispenses;

    public function __construct()
    {
        $this->dispenses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): self
    {
        $this->level = $level;
        return $this;
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

    /**
     * @return Collection<int, Dispense>
     */
    public function getDispenses(): Collection
    {
        return $this->dispenses;
    }

    public function addDispense(Dispense $dispense): static
    {
        if (!$this->dispenses->contains($dispense)) {
            $this->dispenses->add($dispense);
        }

        return $this;
    }

    public function removeDispense(Dispense $dispense): static
    {
        $this->dispenses->removeElement($dispense);

        return $this;
    }

}
