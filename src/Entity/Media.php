<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[UniqueEntity(
    fields: ['link', 'band'],
    message: 'Lien déjà utilisé pour ce groupe',
)]
#[Vich\Uploadable]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\ManyToOne(inversedBy: 'medias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Band $band = null;

    #[ORM\Column(type: "string", length: 80, enumType: MediaTypeEnum::class)]
    private MediaTypeEnum $mediaType;

    #[Vich\UploadableField(mapping: 'media_picture', fileNameProperty: 'link', size: 'pictureSize')]
    #[Assert\File(
        maxSize: '3M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $pictureFile = null;

    #[ORM\Column(nullable: true)]
    private ?int $pictureSize = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;


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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function setPictureFile(?File $pictureFile = null): void
    {
        $this->pictureFile = $pictureFile;

        if (null !== $pictureFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTime();
        }
    }

    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }
}
