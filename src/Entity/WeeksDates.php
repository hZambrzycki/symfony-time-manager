<?php

namespace App\Entity;

use App\Repository\WeeksDatesRepository;
use Doctrine\ORM\Mapping as ORM;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
/**
 * @ORM\Entity(repositoryClass=WeeksDatesRepository::class)
 */
class WeeksDates
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $start;

    /**
     * @ORM\Column(type="date")
     */
    private $end;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAtTheMoment;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateAtTheMoment(): ?\DateTimeInterface
    {
        return $this->dateAtTheMoment;
    }

    public function setDateAtTheMoment(\DateTimeInterface $dateAtTheMoment): self
    {
        $this->dateAtTheMoment = $dateAtTheMoment;

        return $this;
    }
}
