<?php

namespace App\Entity;

use App\Repository\ExerciceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExerciceRepository::class)
 */
class Exercice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $break;

    /**
     * @ORM\Column(type="boolean")
     */
    private $stop;

    /**
     * @ORM\OneToMany(targetEntity=SerieOrRun::class, mappedBy="exercice", orphanRemoval=true)
     */
    private $serieOrRuns;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRun;

    public function __construct()
    {
        $this->serieOrRuns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBreak(): ?int
    {
        return $this->break;
    }

    public function setBreak(?int $break): self
    {
        $this->break = $break;

        return $this;
    }

    public function getStop(): ?bool
    {
        return $this->stop;
    }

    public function setStop(bool $stop): self
    {
        $this->stop = $stop;

        return $this;
    }

    /**
     * @return Collection|SerieOrRun[]
     */
    public function getSerieOrRuns(): Collection
    {
        return $this->serieOrRuns;
    }

    public function addSerieOrRun(SerieOrRun $serieOrRun): self
    {
        if (!$this->serieOrRuns->contains($serieOrRun)) {
            $this->serieOrRuns[] = $serieOrRun;
            $serieOrRun->setExercice($this);
        }

        return $this;
    }

    public function removeSerieOrRun(SerieOrRun $serieOrRun): self
    {
        if ($this->serieOrRuns->removeElement($serieOrRun)) {
            // set the owning side to null (unless already changed)
            if ($serieOrRun->getExercice() === $this) {
                $serieOrRun->setExercice(null);
            }
        }

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

    public function getIsRun(): ?bool
    {
        return $this->isRun;
    }

    public function setIsRun(bool $isRun): self
    {
        $this->isRun = $isRun;

        return $this;
    }
}