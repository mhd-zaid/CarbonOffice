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

    #[ORM\Column(length: 300)]
    private ?string $title = null;

    #[ORM\Column(length: 1000)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column(length: 1000)]
    private ?string $requirements = null;


    #[ORM\ManyToOne(inversedBy: 'formations')]
    private ?Reward $reward = null;

    #[ORM\ManyToMany(targetEntity: Skills::class, inversedBy: 'formations')]
    private Collection $skills;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: Mentor::class)]
    private Collection $mentors;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: Dispense::class)]
    private Collection $dispenses;
  
    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->mentors = new ArrayCollection();
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

    public function getReward(): ?Reward
    {
        return $this->reward;
    }

    public function setReward(?Reward $reward): self
    {
        $this->reward = $reward;

        return $this;
    }

    /**
     * @return Collection<int, Skills>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skills $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }

        return $this;
    }
    

    /*
     * @return Collection<int, Mentor>
     */
    public function getMentors(): Collection
    {
        return $this->mentors;
    }

    public function addMentor(Mentor $mentor): self
    {
        if (!$this->mentors->contains($mentor)) {
            $this->mentors->add($mentor);
            $mentor->setFormation($this);
        }

        return $this;
    }

    public function removeSkill(Skills $skill): self
    {
        $this->skills->removeElement($skill);

        return $this;
    }
    public function removeMentor(Mentor $mentor): self
    {
        if ($this->mentors->removeElement($mentor)) {
            // set the owning side to null (unless already changed)
            if ($mentor->getFormation() === $this) {
                $mentor->setFormation(null);
            }
        }

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
            $dispense->setFormation($this);
        }

        return $this;
    }

    public function removeDispense(Dispense $dispense): self
    {
        if ($this->dispenses->removeElement($dispense)) {
            // set the owning side to null (unless already changed)
            if ($dispense->getFormation() === $this) {
                $dispense->setFormation(null);
            }
        }

        return $this;
    }
}
