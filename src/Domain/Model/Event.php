<?php

declare(strict_types=1);

namespace App\Domain\Model;

class Event
{
    private ?int $id = null;

    private ?string $name = null;

    /** @var iterable<int, Band> */
    private iterable $bands;

    private ?string $slug = null;

    public function __construct()
    {
        $this->bands = [];
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

    /**
     * @return iterable<int, Band>
     */
    public function getBands(): iterable
    {
        return $this->bands;
    }

    public function addBand(Band $band): self
    {
        foreach ($this->bands as $existingBand) {
            if ($existingBand === $band) {
                return $this;
            }
        }

        $this->bands[] = $band;

        return $this;
    }

    public function removeBand(Band $band): self
    {
        foreach ($this->bands as $key => $existingBand) {
            if ($existingBand === $band) {
                unset($this->bands[$key]);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
