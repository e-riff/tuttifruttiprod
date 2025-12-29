<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Enums\BandPriceEnum;
use DateTimeImmutable;

/**
 * @phpstan-type BandPrice BandPriceEnum
 */
class Band
{
    private ?int $id = null;

    private ?string $name = null;

    private ?string $description = null;

    private ?bool $isActive = null;

    /** @var iterable<int, Concert> */
    private iterable $concerts;

    private ?string $flashInformation = null;

    private ?string $tagline = null;

    /** @var iterable<int, Event> */
    private iterable $events;

    /** @var iterable<int, MusicStyle> */
    private iterable $musicStyles;

    /** @var iterable<int, Media> */
    private iterable $medias;

    private ?string $slug = null;

    private ?string $picture = null;

    private ?bool $isOnHomepage = false;

    /** @var iterable<int, Musician> */
    private iterable $musicians;

    private ?DateTimeImmutable $updatedAt = null;

    private ?BandPriceEnum $priceCategory = null;

    private ?string $color = '#000000';

    private ?Musician $leader = null;

    public function __construct()
    {
        $this->concerts = [];
        $this->events = [];
        $this->musicStyles = [];
        $this->medias = [];
        $this->musicians = [];
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
     * @return iterable<int, Concert>
     */
    public function getConcerts(): iterable
    {
        return $this->concerts;
    }

    public function addConcert(Concert $concert): self
    {
        foreach ($this->concerts as $existingConcert) {
            if ($existingConcert === $concert) {
                return $this;
            }
        }

        $this->concerts[] = $concert;
        $concert->setBand($this);

        return $this;
    }

    public function removeConcert(Concert $concert): self
    {
        foreach ($this->concerts as $key => $existingConcert) {
            if ($existingConcert === $concert) {
                unset($this->concerts[$key]);
                // set the owning side to null (unless already changed)
                if ($concert->getBand() === $this) {
                    $concert->setBand(null);
                }
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
     * @return iterable<int, Event>
     */
    public function getEvents(): iterable
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        foreach ($this->events as $existingEvent) {
            if ($existingEvent === $event) {
                return $this;
            }
        }

        $this->events[] = $event;
        $event->addBand($this);

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        foreach ($this->events as $key => $existingEvent) {
            if ($existingEvent === $event) {
                unset($this->events[$key]);
                $event->removeBand($this);
            }
        }

        return $this;
    }

    /**
     * @return iterable<int, MusicStyle>
     */
    public function getMusicStyles(): iterable
    {
        return $this->musicStyles;
    }

    public function addMusicStyle(MusicStyle $musicStyle): self
    {
        foreach ($this->musicStyles as $existingMusicStyle) {
            if ($existingMusicStyle === $musicStyle) {
                return $this;
            }
        }

        $this->musicStyles[] = $musicStyle;
        $musicStyle->addBand($this);

        return $this;
    }

    public function removeMusicStyle(MusicStyle $musicStyle): self
    {
        foreach ($this->musicStyles as $key => $existingMusicStyle) {
            if ($existingMusicStyle === $musicStyle) {
                unset($this->musicStyles[$key]);
                $musicStyle->removeBand($this);
            }
        }

        return $this;
    }

    /**
     * @return iterable<int, Media>
     */
    public function getMedias(): iterable
    {
        return $this->medias;
    }

    public function addMedia(Media $media): self
    {
        foreach ($this->medias as $existingMedia) {
            if ($existingMedia === $media) {
                return $this;
            }
        }

        $this->medias[] = $media;
        $media->setBand($this);

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        foreach ($this->medias as $key => $existingMedia) {
            if ($existingMedia === $media) {
                unset($this->medias[$key]);
                // set the owning side to null (unless already changed)
                if ($media->getBand() === $this) {
                    $media->setBand(null);
                }
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
     * @return iterable<int, Musician>
     */
    public function getMusicians(): iterable
    {
        return $this->musicians;
    }

    public function addMusician(Musician $musician): self
    {
        foreach ($this->musicians as $existingMusician) {
            if ($existingMusician === $musician) {
                return $this;
            }
        }

        $this->musicians[] = $musician;
        $musician->addBand($this);

        return $this;
    }

    public function removeMusician(Musician $musician): self
    {
        foreach ($this->musicians as $key => $existingMusician) {
            if ($existingMusician === $musician) {
                unset($this->musicians[$key]);
                $musician->removeBand($this);
            }
        }

        if ($this->leader === $musician) {
            $this->leader = null;
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
        if ($leader) {
            $found = false;
            foreach ($this->musicians as $existingMusician) {
                if ($existingMusician === $leader) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $this->addMusician($leader);
            }
        }

        $this->leader = $leader;

        return $this;
    }
}
