<?php

namespace App\Entity;

use App\Repository\BandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BandRepository::class)]
class Band
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\OneToMany(mappedBy: 'band', targetEntity: Concert::class, orphanRemoval: true)]
    private Collection $concerts;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $flashInformation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tagline = null;

    #[ORM\ManyToMany(targetEntity: PossibleOccasion::class, mappedBy: 'bands')]
    private Collection $possibleOccasions;

    #[ORM\ManyToMany(targetEntity: PrestationStyle::class, mappedBy: 'bands')]
    private Collection $prestationStyles;

    public function __construct()
    {
        $this->concerts = new ArrayCollection();
        $this->possibleOccasions = new ArrayCollection();
        $this->prestationStyles = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, Concert>
     */
    public function getConcerts(): Collection
    {
        return $this->concerts;
    }

    public function addConcert(Concert $concert): self
    {
        if (!$this->concerts->contains($concert)) {
            $this->concerts->add($concert);
            $concert->setBand($this);
        }

        return $this;
    }

    public function removeConcert(Concert $concert): self
    {
        if ($this->concerts->removeElement($concert)) {
            // set the owning side to null (unless already changed)
            if ($concert->getBand() === $this) {
                $concert->setBand(null);
            }
        }

        return $this;
    }

    public function getFlashInformation(): ?string
    {
        return $this->flashInformation;
    }

    public function setFlashInformation(?string $flashInformation): self
    {
        $this->flashInformation = $flashInformation;

        return $this;
    }

    public function getTagline(): ?string
    {
        return $this->tagline;
    }

    public function setTagline(?string $tagline): self
    {
        $this->tagline = $tagline;

        return $this;
    }

    /**
     * @return Collection<int, PossibleOccasion>
     */
    public function getPossibleOccasions(): Collection
    {
        return $this->possibleOccasions;
    }

    public function addPossibleOccasion(PossibleOccasion $possibleOccasion): self
    {
        if (!$this->possibleOccasions->contains($possibleOccasion)) {
            $this->possibleOccasions->add($possibleOccasion);
            $possibleOccasion->addBand($this);
        }

        return $this;
    }

    public function removePossibleOccasion(PossibleOccasion $possibleOccasion): self
    {
        if ($this->possibleOccasions->removeElement($possibleOccasion)) {
            $possibleOccasion->removeBand($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, PrestationStyle>
     */
    public function getPrestationStyles(): Collection
    {
        return $this->prestationStyles;
    }

    public function addPrestationStyle(PrestationStyle $prestationStyle): self
    {
        if (!$this->prestationStyles->contains($prestationStyle)) {
            $this->prestationStyles->add($prestationStyle);
            $prestationStyle->addBand($this);
        }

        return $this;
    }

    public function removePrestationStyle(PrestationStyle $prestationStyle): self
    {
        if ($this->prestationStyles->removeElement($prestationStyle)) {
            $prestationStyle->removeBand($this);
        }

        return $this;
    }
}
