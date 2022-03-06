<?php

namespace App\Entity;

use App\Repository\PrestataireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrestataireRepository::class)
 */
class Prestataire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $siteweb;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $numTel;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $numTva;

    /**
     * @ORM\ManyToMany(targetEntity=CategorieDeServices::class, inversedBy="prestataires")
     */
    private $services;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="prestataire")
     */
    private $stages;

    /**
     * @ORM\OneToMany(targetEntity=Promotion::class, mappedBy="prestataire")
     */
    private $promotions;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, cascade={"persist", "remove"}, mappedBy="prestataire")
     */
    private $images;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->stages = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->images = new ArrayCollection();
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

    public function getSiteweb(): ?string
    {
        return $this->siteweb;
    }

    public function setSiteweb(string $siteweb): self
    {
        $this->siteweb = $siteweb;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getNumTva(): ?string
    {
        return $this->numTva;
    }

    public function setNumTva(string $numTva): self
    {
        $this->numTva = $numTva;

        return $this;
    }

    /**
     * @return Collection|CategorieDeServices[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(CategorieDeServices $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
        }

        return $this;
    }

    public function removeService(CategorieDeServices $service): self
    {
        $this->services->removeElement($service);

        return $this;
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

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setPrestataire($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getPrestataire() === $this) {
                $stage->setPrestataire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Promotion[]
     */
    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (!$this->promotions->contains($promotion)) {
            $this->promotions[] = $promotion;
            $promotion->setPrestataire($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotions->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getPrestataire() === $this) {
                $promotion->setPrestataire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setPrestataire($this);
        }

        return $this;
    }

    public function getLogo(){
        foreach($this->getImages() as $img){
            if($img->getOrdre() == 0){
                return $img;
            }
        }
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPrestataire() === $this) {
                $image->setPrestataire(null);
            }
        }

        return $this;
    }
}
