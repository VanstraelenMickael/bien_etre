<?php

namespace App\Entity;

use App\Repository\CategorieDeServicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieDeServicesRepository::class)
 */
class CategorieDeServices
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enAvant = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valide = false;

    /**
     * @ORM\ManyToMany(targetEntity=Prestataire::class, mappedBy="services")
     */
    private $prestataires;

    public function __construct()
    {
        $this->prestataires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEnAvant(): ?bool
    {
        return $this->enAvant;
    }

    public function setEnAvant(bool $enAvant): self
    {
        $this->enAvant = $enAvant;

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    /**
     * @return Collection|Prestataire[]
     */
    public function getPrestataires(): Collection
    {
        return $this->prestataires;
    }

    public function addPrestataire(Prestataire $prestataire): self
    {
        if (!$this->prestataires->contains($prestataire)) {
            $this->prestataires[] = $prestataire;
            $prestataire->addService($this);
        }

        return $this;
    }

    public function removePrestataire(Prestataire $prestataire): self
    {
        if ($this->prestataires->removeElement($prestataire)) {
            $prestataire->removeService($this);
        }

        return $this;
    }
}
