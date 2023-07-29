<?php

namespace App\Entity;

use App\Repository\DispenseRepository;
use DateTimeInterface;
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

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?DateTimeInterface $startTime = null;


    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\ManyToOne(inversedBy: 'dispenses')]
    private ?Mentor $mentor = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'dispenses')]
    private Collection $consultants;

    #[ORM\ManyToOne(inversedBy: 'dispenses')]
    private ?Formation $formation = null;

    #[ORM\OneToMany(mappedBy: 'dispense', targetEntity: Reward::class)]
    private Collection $rewards;

    public function __construct()
    {
        $this->consultants = new ArrayCollection();
        $this->rewards = new ArrayCollection();
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

    public function getStartTime(): ?DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getMentor(): ?Mentor
    {
        return $this->mentor;
    }

    public function setMentor(?Mentor $mentor): self
    {
        $this->mentor = $mentor;

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

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * @return Collection<int, Reward>
     */
    public function getRewards(): Collection
    {
        return $this->rewards;
    }

    public function addReward(Reward $reward): static
    {
        if (!$this->rewards->contains($reward)) {
            $this->rewards->add($reward);
            $reward->setDispense($this);
        }

        return $this;
    }

    public function removeReward(Reward $reward): static
    {
        if ($this->rewards->removeElement($reward)) {
            // set the owning side to null (unless already changed)
            if ($reward->getDispense() === $this) {
                $reward->setDispense(null);
            }
        }

        return $this;
    }
}
