<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column(length: 255)]
    private ?string $requirements = null;

    #[ORM\Column(length: 255)]
    private ?string $skills = null;

    #[ORM\ManyToMany(targetEntity: Dispense::class, mappedBy: 'formations')]
    private Collection $dispenses;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    private ?Reward $reward = null;

    public function __construct()
    {
        $this->dispenses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getRequirements(): ?string
    {
        return $this->requirements;
    }

    public function setRequirements(string $requirements): self
    {
        $this->requirements = $requirements;

        return $this;
    }

    public function getSkills(): ?string
    {
        return $this->skills;
    }

    public function setSkills(string $skill): self
    {
        $this->skills = $skill;

        return $this;
    }

    /**
     * @return Collection<int, Dispense>
     */
    public function getDispenses(): Collection
    {
        return $this->dispenses;
    }

    public function addDispense(Dispense $dispense): self
    {
        if (!$this->dispenses->contains($dispense)) {
            $this->dispenses->add($dispense);
            $dispense->addFormation($this);
        }

        return $this;
    }

    public function removeDispense(Dispense $dispense): self
    {
        if ($this->dispenses->removeElement($dispense)) {
            $dispense->removeFormation($this);
        }

        return $this;
    }

    public function getReward(): ?Reward
    {
        return $this->reward;
    }

    public function setReward(?Reward $reward): self
    {
        $this->reward = $reward;

        return $this;
    }
}
