<?php

namespace App\Entity;

use App\Repository\HoursOfProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HoursOfProjectRepository::class)
 */
class HoursOfProject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="hoursOfProjects")
     */
    private $projectName;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="nHours")
     */
    private $nameConsultant;

    /**
     * @ORM\Column(type="integer")
     */
    private $nHours;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\Column(type="date")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $paymentPerHour;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $total;

    public function __toString() {
       return $this->nameConsultant;
     
      
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectName(): ?Project
    {
        return $this->projectName;
    }

    public function setProjectName(?Project $projectName): self
    {
        $this->projectName = $projectName;

        return $this;
    }
    public function setProjectName1(?String $projectName): self
    {
        $this->projectName = $projectName;

        return $this;
    }
    public function getNameConsultant(): ?User
    {
        return $this->nameConsultant;
    }

    public function setNameConsultant(?User $nameConsultant): self
    {
        $this->nameConsultant = $nameConsultant;

        return $this;
    }
    public function setNameConsultant1(?String $nameConsultant): self
    {
        $this->nameConsultant = $nameConsultant;

        return $this;
    }
    public function getNHours(): ?int
    {
        return $this->nHours;
    }

    public function setNHours(int $nHours): self
    {
        $this->nHours = $nHours;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPaymentPerHour(): ?int
    {
        return $this->paymentPerHour;
    }

    public function setPaymentPerHour(?int $paymentPerHour): self
    {
        $this->paymentPerHour = $paymentPerHour;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(?int $total): self
    {
        $this->total = $total;

        return $this;
    }
}
