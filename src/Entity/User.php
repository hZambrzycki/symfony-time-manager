<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_8D93D649E7927C74", columns={"email"})}, indexes={@ORM\Index(name="username", columns={"username"})})
 * @ORM\Entity
 */
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=180, nullable=false)
     */
    private $email;
    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="json", nullable=false)
     */
    private $roles= [];
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     * 
     */
    private $username;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, mappedBy="membersOfTheProject")
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="managersOfTheProject")
     */
    private $managers;

    /**
     * @ORM\OneToMany(targetEntity=HoursOfProject::class, mappedBy="nameConsultant")
     */
    private $nHours;

    /**
     * @ORM\OneToMany(targetEntity=UserAskingForExtraHours::class, mappedBy="user")
     */
    private $userExtraHoursPetition;


    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->managers = new ArrayCollection();
        $this->nHours = new ArrayCollection();
        $this->userExtraHoursPetition = new ArrayCollection();
        

     
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
        $roles[] = 'ROLE_CONSULTANT';

        return array_unique($roles);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function setUsername(string $username): self
    {
        $this->username = $username;

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
    public function __toString() {
        return $this->username;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->addMembersOfTheProject($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            $project->removeMembersOfTheProject($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getManagers(): Collection
    {
        return $this->managers;
    }

    public function addManager(Project $manager): self
    {
        if (!$this->managers->contains($manager)) {
            $this->managers[] = $manager;
            $manager->setManagersOfTheProject($this);
        }

        return $this;
    }

    public function removeManager(Project $manager): self
    {
        if ($this->managers->removeElement($manager)) {
            // set the owning side to null (unless already changed)
            if ($manager->getManagersOfTheProject() === $this) {
                $manager->setManagersOfTheProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HoursOfProject>
     */
    public function getNHours(): Collection
    {
        return $this->nHours;
    }

    public function addNHour(HoursOfProject $nHour): self
    {
        if (!$this->nHours->contains($nHour)) {
            $this->nHours[] = $nHour;
            $nHour->setNameConsultant($this);
        }

        return $this;
    }

    public function removeNHour(HoursOfProject $nHour): self
    {
        if ($this->nHours->removeElement($nHour)) {
            // set the owning side to null (unless already changed)
            if ($nHour->getNameConsultant() === $this) {
                $nHour->setNameConsultant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserAskingForExtraHours>
     */
    public function getUserExtraHoursPetition(): Collection
    {
        return $this->userExtraHoursPetition;
    }

    public function addUserExtraHoursPetition(UserAskingForExtraHours $userExtraHoursPetition): self
    {
        if (!$this->userExtraHoursPetition->contains($userExtraHoursPetition)) {
            $this->userExtraHoursPetition[] = $userExtraHoursPetition;
            $userExtraHoursPetition->setUser($this);
        }

        return $this;
    }

    public function removeUserExtraHoursPetition(UserAskingForExtraHours $userExtraHoursPetition): self
    {
        if ($this->userExtraHoursPetition->removeElement($userExtraHoursPetition)) {
            // set the owning side to null (unless already changed)
            if ($userExtraHoursPetition->getUser() === $this) {
                $userExtraHoursPetition->setUser(null);
            }
        }

        return $this;
    }


}