<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $Total = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $CreatedAt = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneCmd::class)]
    private Collection $ligneCmds;

    public function __construct()
    {
        $this->ligneCmds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->Total;
    }

    public function setTotal(string $Total): self
    {
        $this->Total = $Total;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    /**
     * @return Collection<int, LigneCmd>
     */
    public function getLigneCmds(): Collection
    {
        return $this->ligneCmds;
    }

    public function addLigneCmd(LigneCmd $ligneCmd): self
    {
        if (!$this->ligneCmds->contains($ligneCmd)) {
            $this->ligneCmds->add($ligneCmd);
            $ligneCmd->setCommande($this);
        }

        return $this;
    }

    public function removeLigneCmd(LigneCmd $ligneCmd): self
    {
        if ($this->ligneCmds->removeElement($ligneCmd)) {
            // set the owning side to null (unless already changed)
            if ($ligneCmd->getCommande() === $this) {
                $ligneCmd->setCommande(null);
            }
        }

        return $this;
    }
}
