<?php

declare(strict_types=1);

namespace App\Domain\Model;

use DateTimeImmutable;

class Musician
{
    private ?int $id = null;

    private ?string $firstname = null;

    private ?string $lastname = null;

    private ?string $email = null;

    private ?string $phone = null;

    private ?bool $isActive = null;

    /** @var iterable<int, Band> */
    private iterable $bands;

    private ?string $picture = null;

    private ?DateTimeImmutable $updatedAt = null;

    /**
     * @var iterable<int, Band>
     */
    private iterable $leadingBands;

    public function __construct()
    {
        $this->bands = [];
        $this->leadingBands = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPictureFile(): ?object
    {
        return null;
    }

    public function setPictureFile(?object $pictureFile = null): self
    {
        if ($pictureFile) {
            $this->updatedAt = new DateTimeImmutable('now');
        }

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return iterable<int, Band>
     */
    public function getLeadingBands(): iterable
    {
        return $this->leadingBands;
    }

    public function addLeadingBand(Band $leadingBand): static
    {
        foreach ($this->leadingBands as $existingBand) {
            if ($existingBand === $leadingBand) {
                return $this;
            }
        }

        $this->leadingBands[] = $leadingBand;
        $leadingBand->setLeader($this);

        return $this;
    }

    public function removeLeadingBand(Band $leadingBand): static
    {
        foreach ($this->leadingBands as $key => $existingBand) {
            if ($existingBand === $leadingBand) {
                unset($this->leadingBands[$key]);
                // set the owning side to null (unless already changed)
                if ($leadingBand->getLeader() === $this) {
                    $leadingBand->setLeader(null);
                }
            }
        }

        return $this;
    }
}
