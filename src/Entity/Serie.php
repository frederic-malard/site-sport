<?php

namespace App\Entity;

use App\Entity\SerieOrRun;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SerieRepository;

/**
 * @ORM\Entity(repositoryClass=SerieRepository::class)
 */
class Serie extends SerieOrRun
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
    private $repetitions;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepetitions(): ?float
    {
        return $this->repetitions;
    }

    public function setRepetitions(float $repetitions): self
    {
        $this->repetitions = $repetitions;

        return $this;
    }
}
