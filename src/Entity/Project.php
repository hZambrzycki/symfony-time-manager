<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name="project", indexes={@ORM\Index(name="nameProject", columns={"nameProject"})})
 * @ORM\Entity
 */
class Project
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
     * @ORM\Column(name="nameProject", type="string", length=255, nullable=false)
     */
    private $nameproject;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="StartDate", type="date", nullable=false)
     */
    private $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="EndDate", type="date", nullable=false)
     */
    private $enddate;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="projects")
     */
    private $membersOfTheProject;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="managers")
     */
    private $managersOfTheProject;

    /**
     * @ORM\OneToOne(targetEntity=Calendar::class, mappedBy="projectsEvents", cascade={"persist", "remove"})
     */
    private $calendar;


    /**
     * @ORM\OneToMany(targetEntity=HoursOfProject::class, mappedBy="projectName")
     */
    private $hoursOfProjects;

 



    public function __construct()
    {
        $this->membersOfTheProject = new ArrayCollection();
        $this->projectsHours = new ArrayCollection();
        $this->hoursOfProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameproject(): ?string
    {
        return $this->nameproject;
    }

    public function setNameproject(string $nameproject): self
    {
        $this->nameproject = $nameproject;

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

    public function getStartdate(): ?\DateTime
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTime $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate(): ?\DateTime
    {
        return $this->enddate;
    }

    public function setEnddate(\DateTime $enddate): self
    {
        $this->enddate = $enddate;

        return $this;
    }

    public function __toString() {
        return $this->nameproject;
        return $this->enddate;
    }

    /**
     * @return Collection<int, User>
     */
    public function getMembersOfTheProject(): Collection
    {
        return $this->membersOfTheProject;
    }

    public function addMembersOfTheProject(User $membersOfTheProject): self
    {
        if (!$this->membersOfTheProject->contains($membersOfTheProject)) {
            $this->membersOfTheProject[] = $membersOfTheProject;
        }

        return $this;
    }

    public function removeMembersOfTheProject(User $membersOfTheProject): self
    {
        $this->membersOfTheProject->removeElement($membersOfTheProject);

        return $this;
    }

    public function getManagersOfTheProject(): ?User
    {
        return $this->managersOfTheProject;
    }

    public function setManagersOfTheProject(?User $managersOfTheProject): self
    {
        $this->managersOfTheProject = $managersOfTheProject;

        return $this;
    }

    public function getCalendar(): ?Calendar
    {
        return $this->calendar;
    }

    public function setCalendar(?Calendar $calendar): self
    {
        // unset the owning side of the relation if necessary
        if ($calendar === null && $this->calendar !== null) {
            $this->calendar->setProjectsEvents(null);
        }

        // set the owning side of the relation if necessary
        if ($calendar !== null && $calendar->getProjectsEvents() !== $this) {
            $calendar->setProjectsEvents($this);
        }

        $this->calendar = $calendar;

        return $this;
    }

    /**
     * @return Collection<int, HoursOfProject>
     */
    public function getHoursOfProjects(): Collection
    {
        return $this->hoursOfProjects;
    }

    public function addHoursOfProject(HoursOfProject $hoursOfProject): self
    {
        if (!$this->hoursOfProjects->contains($hoursOfProject)) {
            $this->hoursOfProjects[] = $hoursOfProject;
            $hoursOfProject->setProjectName($this);
        }

        return $this;
    }

    public function removeHoursOfProject(HoursOfProject $hoursOfProject): self
    {
        if ($this->hoursOfProjects->removeElement($hoursOfProject)) {
            // set the owning side to null (unless already changed)
            if ($hoursOfProject->getProjectName() === $this) {
                $hoursOfProject->setProjectName(null);
            }
        }

        return $this;
    }


}
