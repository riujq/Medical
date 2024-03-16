<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[Vich\Uploadable]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'image')]
    #[Assert\Image(maxSize: '5024k',mimeTypes : ['image/png','image/gif','image/jpg','image/jpeg'])]
    private ?File $imageFile = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SousCategory $sousCategory = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $prix = null;

    #[ORM\Column(nullable: true)]
    public ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

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

    public function getSousCategory(): ?SousCategory
    {
        return $this->sousCategory;
    }

    public function setSousCategory(?SousCategory $sousCategory): static
    {
        $this->sousCategory = $sousCategory;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }
}
