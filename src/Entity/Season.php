<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeasonRepository::class)]
class Season
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'program')]
    #[ORM\JoinColumn(nullable: false)]
    private ?program $program = null;

    #[ORM\OneToMany(mappedBy: 'season', targetEntity: Episode::class)]
    private Collection $season;

    public function __construct()
    {
        $this->season = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getProgram(): ?program
    {
        return $this->program;
    }

    public function setProgram(?program $program): static
    {
        $this->program = $program;

        return $this;
    }

    /**
     * @return Collection<int, Episode>
     */
    public function getSeason(): Collection
    {
        return $this->season;
    }

    public function addSeason(Episode $season): static
    {
        if (!$this->season->contains($season)) {
            $this->season->add($season);
            $season->setSeason($this);
        }

        return $this;
    }

    public function removeSeason(Episode $season): static
    {
        if ($this->season->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getSeason() === $this) {
                $season->setSeason(null);
            }
        }

        return $this;
    }
}