<?php

namespace App\Entity;

use App\Repository\MentorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MentorRepository::class)]
class Mentor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'mentors')]
    private ?User $consultant = null;

    #[ORM\ManyToOne(inversedBy: 'mentors')]
    private ?Formation $formation = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\OneToMany(mappedBy: 'mentor', targetEntity: Dispense::class)]
    private Collection $dispenses;

    public function __construct()
    {
        $this->dispenses = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->consultant->getFirstname() . ' ' . $this->consultant->getLastname();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConsultant(): ?User
    {
        return $this->consultant;
    }

    public function setConsultant(?User $consultant): self
    {
        $this->consultant = $consultant;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

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
            $dispense->setMentor($this);
        }

        return $this;
    }

    public function removeDispense(Dispense $dispense): self
    {
        if ($this->dispenses->removeElement($dispense)) {
            // set the owning side to null (unless already changed)
            if ($dispense->getMentor() === $this) {
                $dispense->setMentor(null);
            }
        }

        return $this;
    }
}
