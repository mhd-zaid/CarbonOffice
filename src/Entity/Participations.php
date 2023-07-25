<?php

namespace App\Entity;

use App\Repository\ParticipationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipationsRepository::class)]
class Participations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    

    #[ORM\ManyToMany(targetEntity: Dispense::class, inversedBy: 'participations')]
    private Collection $dispenses;

    #[ORM\JoinTable(name: 'participations_mentor')]
    #[ORM\JoinColumn(name: 'participation_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'participationsMentor')]
    private Collection $mentors;

    #[ORM\JoinTable(name: 'participations_consultant')]
    #[ORM\JoinColumn(name: 'participation_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'participationsConsultant')]
    private Collection $consultants;

    public function __construct()
    {
        $this->dispenses = new ArrayCollection();
        $this->mentors = new ArrayCollection();
        $this->consultants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        }

        return $this;
    }

    public function removeDispense(Dispense $dispense): self
    {
        $this->dispenses->removeElement($dispense);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getMentors(): Collection
    {
        return $this->mentors;
    }

    public function addMentor(User $mentor): self
    {
        if (!$this->mentors->contains($mentor)) {
            $this->mentors->add($mentor);
        }

        return $this;
    }

    public function removeMentor(User $mentor): self
    {
        $this->mentors->removeElement($mentor);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getConsultants(): Collection
    {
        return $this->consultants;
    }

    public function addConsultant(User $consultant): self
    {
        if (!$this->consultants->contains($consultant)) {
            $this->consultants->add($consultant);
        }

        return $this;
    }

    public function removeConsultant(User $consultant): self
    {
        $this->consultants->removeElement($consultant);

        return $this;
    }
}
