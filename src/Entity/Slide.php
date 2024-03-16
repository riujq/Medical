<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SlideRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SlideRepository::class)]
#[Vich\Uploadable]
class Slide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    private ?string $Image = null;

    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'image')]
    #[Assert\Image(maxSize: '5024k',mimeTypes : ['image/png','image/gif','image/jpg','image/jpeg',])]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    public ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): static
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): static
    {
        $this->Image = $Image;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): static
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
}
