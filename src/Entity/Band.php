<?php

namespace App\Entity;

use App\Repository\BandRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BandRepository::class)]
#[Vich\Uploadable]
#[UniqueEntity(
    fields: ['name'],
    message: 'Ce nom est déjà utilisé',
)]
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

    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'bands')]
    private Collection $events;

    #[ORM\ManyToMany(targetEntity: MusicStyle::class, mappedBy: 'bands')]
    private Collection $musicStyles;

    #[ORM\OneToMany(mappedBy: 'band', targetEntity: Media::class, orphanRemoval: true)]
    private Collection $medias;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['name'])]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[Vich\UploadableField(mapping: 'band_picture', fileNameProperty: 'picture')]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $pictureFile = null;

    #[ORM\Column]
    private ?bool $isOnHomepage = false;

    #[ORM\ManyToMany(targetEntity: Musician::class, mappedBy: 'bands')]
    private Collection $musicians;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: "string", nullable: true, enumType: BandPriceEnum::class)]
    private ?BandPriceEnum $priceCategory = null;

    #[ORM\Column(length: 7, options: ['default' => '#000000'])]
    #[Assert\CssColor]
    private ?string $color = '#000000';

    #[ORM\ManyToOne(inversedBy: 'leadingBands')]
    private ?Musician $leader = null;

    public function __construct()
    {
        $this->concerts = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->musicStyles = new ArrayCollection();
        $this->medias = new ArrayCollection();
        $this->musicians = new ArrayCollection();
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
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->addBand($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeBand($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, MusicStyle>
     */
    public function getMusicStyles(): Collection
    {
        return $this->musicStyles;
    }

    public function addMusicStyle(MusicStyle $musicStyle): self
    {
        if (!$this->musicStyles->contains($musicStyle)) {
            $this->musicStyles->add($musicStyle);
            $musicStyle->addBand($this);
        }

        return $this;
    }

    public function removeMusicStyle(MusicStyle $musicStyle): self
    {
        if ($this->musicStyles->removeElement($musicStyle)) {
            $musicStyle->removeBand($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias->add($media);
            $media->setBand($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->medias->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getBand() === $this) {
                $media->setBand(null);
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

    /**
     * @param File|null $pictureFile
     */
    public function setPictureFile(?File $pictureFile = null): self
    {
        $this->pictureFile = $pictureFile;
        if ($pictureFile) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function isIsOnHomepage(): ?bool
    {
        return $this->isOnHomepage;
    }

    public function setIsOnHomepage(bool $isOnHomepage): self
    {
        $this->isOnHomepage = $isOnHomepage;

        return $this;
    }

    /**
     * @return Collection<int, Musician>
     */
    public function getMusicians(): Collection
    {
        return $this->musicians;
    }

    public function addMusician(Musician $musician): self
    {
        if (!$this->musicians->contains($musician)) {
            $this->musicians->add($musician);
            $musician->addBand($this);
        }

        return $this;
    }

    public function removeMusician(Musician $musician): self
    {
        if ($this->musicians->removeElement($musician)) {
            $musician->removeBand($this);
        }
        if ($this->leader === $musician) {
            $this->leader = null;
        }

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPriceCategory(): ?BandPriceEnum
    {
        return $this->priceCategory;
    }

    public function setPriceCategory(?BandPriceEnum $price): self
    {
        $this->priceCategory = $price;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getLeader(): ?Musician
    {
        return $this->leader;
    }

    public function setLeader(?Musician $leader): static
    {
        if ($leader && !$this->musicians->contains($leader)) {
            $this->addMusician($leader);
        }

        $this->leader = $leader;

        return $this;
    }
}
