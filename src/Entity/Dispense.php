<?php

namespace App\Entity;

use App\Repository\DispenseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DispenseRepository::class)]
class Dispense
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'dispenses')]
    private Collection $mentors;

    #[ORM\ManyToMany(targetEntity: Formation::class, inversedBy: 'dispenses')]
    private Collection $formations;

    #[ORM\ManyToMany(targetEntity: Participations::class, mappedBy: 'dispenses')]
    private Collection $participations;

    public function __construct()
    {
        $this->mentors = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->participations = new ArrayCollection();
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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getMentor(): Collection
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
     * @return Collection<int, Formation>
     */
    public function getFormation(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        $this->formations->removeElement($formation);

        return $this;
    }

    /**
     * @return Collection<int, Participations>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participations $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->addDispense($this);
        }

        return $this;
    }

    public function removeParticipation(Participations $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            $participation->removeDispense($this);
        }

        return $this;
    }
}
