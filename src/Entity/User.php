<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use Traits\TimestampableTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    private ?string $plainPassword = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column]
    private ?int $zipCode = null;

    #[ORM\ManyToMany(targetEntity: Dispense::class, mappedBy: 'mentors')]
    private Collection $dispenses;

    #[ORM\ManyToMany(targetEntity: Participations::class, mappedBy: 'mentors')]
    private Collection $participationsMentor;

    #[ORM\ManyToMany(targetEntity: Participations::class, mappedBy: 'consultants')]
    private Collection $participationsConsultant;

    #[ORM\ManyToMany(targetEntity: Mission::class, mappedBy: 'consultants')]
    private Collection $missions;

    #[ORM\OneToMany(mappedBy: 'manager', targetEntity: Mission::class)]
    private Collection $missionsManager;

    #[ORM\OneToMany(mappedBy: 'consultant', targetEntity: Planning::class)]
    private Collection $plannings;

    public function __construct()
    {
        $this->dispenses = new ArrayCollection();
        $this->participationsMentor = new ArrayCollection();
        $this->participationsConsultant = new ArrayCollection();
        $this->missions = new ArrayCollection();
        $this->missionsManager = new ArrayCollection();
        $this->plannings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFullname(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword): self
    {
        if ($plainPassword !== null) {
            $this->plainPassword = $plainPassword;
            $this->setUpdatedAt(new \DateTime());
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
            $dispense->addMentor($this);
        }

        return $this;
    }

    public function removeDispense(Dispense $dispense): self
    {
        if ($this->dispenses->removeElement($dispense)) {
            $dispense->removeMentor($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Participations>
     */
    public function getParticipationsMentor(): Collection
    {
        return $this->participationsMentor;
    }

    public function addParticipationsMentor(Participations $participationsMentor): self
    {
        if (!$this->participationsMentor->contains($participationsMentor)) {
            $this->participationsMentor->add($participationsMentor);
            $participationsMentor->addMentor($this);
        }

        return $this;
    }

    public function removeParticipationsMentor(Participations $participationsMentor): self
    {
        if ($this->participationsMentor->removeElement($participationsMentor)) {
            $participationsMentor->removeMentor($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Participations>
     */
    public function getParticipationsConsultant(): Collection
    {
        return $this->participationsConsultant;
    }

    public function addParticipationsConsultant(Participations $participationsConsultant): self
    {
        if (!$this->participationsConsultant->contains($participationsConsultant)) {
            $this->participationsConsultant->add($participationsConsultant);
            $participationsConsultant->addConsultant($this);
        }

        return $this;
    }

    public function removeParticipationsConsultant(Participations $participationsConsultant): self
    {
        if ($this->participationsConsultant->removeElement($participationsConsultant)) {
            $participationsConsultant->removeConsultant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Mission>
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions->add($mission);
            $mission->addConsultant($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            $mission->removeConsultant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Mission>
     */
    public function getMissionsManager(): Collection
    {
        return $this->missionsManager;
    }

    public function addMissionsManager(Mission $missionsManager): self
    {
        if (!$this->missionsManager->contains($missionsManager)) {
            $this->missionsManager->add($missionsManager);
            $missionsManager->setManager($this);
        }

        return $this;
    }

    public function removeMissionsManager(Mission $missionsManager): self
    {
        if ($this->missionsManager->removeElement($missionsManager)) {
            // set the owning side to null (unless already changed)
            if ($missionsManager->getManager() === $this) {
                $missionsManager->setManager(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Planning>
     */
    public function getPlannings(): Collection
    {
        return $this->plannings;
    }

    public function addPlanning(Planning $planning): self
    {
        if (!$this->plannings->contains($planning)) {
            $this->plannings->add($planning);
            $planning->setConsultant($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->plannings->removeElement($planning)) {
            // set the owning side to null (unless already changed)
            if ($planning->getConsultant() === $this) {
                $planning->setConsultant(null);
            }
        }

        return $this;
    }
}
