<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Enums\MediaTypeEnum;
use DateTimeImmutable;

class Media
{
    private ?int $id = null;

    private ?string $link = null;

    private ?Band $band = null;

    private MediaTypeEnum $mediaType;

    private ?int $pictureSize = null;

    private ?DateTimeImmutable $updatedAt = null;

    private bool $isActive = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getBand(): ?Band
    {
        return $this->band;
    }

    public function setBand(?Band $band): self
    {
        $this->band = $band;

        return $this;
    }

    public function getMediaType(): MediaTypeEnum
    {
        return $this->mediaType;
    }

    public function setMediaType(MediaTypeEnum $mediaType): self
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    public function getPictureSize(): ?int
    {
        return $this->pictureSize;
    }

    public function setPictureSize(?int $pictureSize): self
    {
        $this->pictureSize = $pictureSize;

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

    public function setPictureFile(?object $pictureFile = null): void
    {
        if (null !== $pictureFile) {
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    public function getPictureFile(): ?object
    {
        return null;
    }

    public function isIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
