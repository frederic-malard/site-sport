<?php

namespace App\Entity;

use App\Entity\SerieOrRun;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RunRepository;

/**
 * @ORM\Entity(repositoryClass=RunRepository::class)
 */
class Run extends SerieOrRun
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $km;

    /**
     * @ORM\Column(type="integer")
     */
    private $positiveElevation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKm(): ?float
    {
        return $this->km;
    }

    public function setKm(float $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getPositiveElevation(): ?int
    {
        return $this->positiveElevation;
    }

    public function setPositiveElevation(int $positiveElevation): self
    {
        $this->positiveElevation = $positiveElevation;

        return $this;
    }
}
