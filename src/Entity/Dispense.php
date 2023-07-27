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

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTimeInterface $start_time = null;


    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\ManyToOne(inversedBy: 'dispenses')]
    private ?Mentor $mentor = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'dispenses')]
    private Collection $consultants;

    public function __construct()
    {
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
        return $this->start_time;
    }

    public function setStarTime(DateTimeInterface $start_time): self
    {
        $this->start_time = $start_time;

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
}
