<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SerieOrRunRepository;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * @MappedSuperclass
 */
class SerieOrRun
{
    /**
     * @ORM\ManyToOne(targetEntity=Exercice::class, inversedBy="serieOrRuns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exercice;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): self
    {
        $this->exercice = $exercice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPassedHours()
    {
        $now = new \DateTimeImmutable();
        $passedTime = $this->createdAt->diff($now);
        return $passedTime->h;
    }

    public function getHoursCategory()
    {
        $h = $this->getPassedHours();
        if ($h < 16)
            return "rest";
        if ($h < 28)
            return "ok";
        if ($h < 72)
            return "limit";
        return "late";
    }

    public function getNext()
    {
        $passedDays = round($this->getPassedHours() / 24);
        $slownessCoefficient = 1 / (1 + (abs(2 - $passedDays) / 3));
        $previous = null;
        if ($this->exercice->getIsRun())
            $previous = $this->getScore();
        else
            $previous = $this->getRepetitions();
        
        return ($previous * (1 + 0.02 * $slownessCoefficient)) + 0.2 * $slownessCoefficient;
    }
}
