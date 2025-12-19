<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\MusicianRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

#[ORM\Entity(repositoryClass: MusicianRepository::class)]
#[UniqueEntity(
    fields: ['lastname', 'firstname'],
    message: 'Cet email est déjà utilisé'
)]
#[Vich\Uploadable]
class Musician
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null; // @phpstan-ignore-line

    #[ORM\Column(type: Types::STRING, length: 80)]
    private ?string $firstname = null;

    #[ORM\Column(type: Types::STRING, length: 80)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(type: Types::STRING, length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private ?bool $isActive = null;

    #[ORM\ManyToMany(targetEntity: Band::class, inversedBy: 'musicians')]
    private Collection $bands;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $picture = null;

    #[Vich\UploadableField(mapping: 'musician_picture', fileNameProperty: 'picture')]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $pictureFile = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Band>
     */
    #[ORM\OneToMany(mappedBy: 'leader', targetEntity: Band::class)]
    private Collection $leadingBands;

    public function __construct()
    {
        $this->bands = new ArrayCollection();
        $this->leadingBands = new ArrayCollection();
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
     * @return Collection<int, Band>
     */
    public function getBands(): Collection
    {
        return $this->bands;
    }

    public function addBand(Band $band): self
    {
        if (!$this->bands->contains($band)) {
            $this->bands->add($band);
        }

        return $this;
    }

    public function removeBand(Band $band): self
    {
        $this->bands->removeElement($band);

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

    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    public function setPictureFile(?File $pictureFile = null): self
    {
        $this->pictureFile = $pictureFile;
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
     * @return Collection<int, Band>
     */
    public function getLeadingBands(): Collection
    {
        return $this->leadingBands;
    }

    public function addLeadingBand(Band $leadingBand): static
    {
        if (!$this->leadingBands->contains($leadingBand)) {
            $this->leadingBands->add($leadingBand);
            $leadingBand->setLeader($this);
        }

        return $this;
    }

    public function removeLeadingBand(Band $leadingBand): static
    {
        if ($this->leadingBands->removeElement($leadingBand)) {
            // set the owning side to null (unless already changed)
            if ($leadingBand->getLeader() === $this) {
                $leadingBand->setLeader(null);
            }
        }

        return $this;
    }
}
