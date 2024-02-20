<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(targetEntity: Actu::class, mappedBy: 'type', orphanRemoval: true)]
    private Collection $actus;

    public function __construct()
    {
        $this->actus = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Actu>
     */
    public function getActus(): Collection
    {
        return $this->actus;
    }

    public function addActu(Actu $actu): static
    {
        if (!$this->actus->contains($actu)) {
            $this->actus->add($actu);
            $actu->setType($this);
        }

        return $this;
    }

    public function removeActu(Actu $actu): static
    {
        if ($this->actus->removeElement($actu)) {
            // set the owning side to null (unless already changed)
            if ($actu->getType() === $this) {
                $actu->setType(null);
            }
        }

        return $this;
    }
}
