<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\InternauteRepository;
use Doctrine\Common\Collections\Collection;
// use Vich\UploaderBundle\Entity\File;
use Symfony\Component\Serializer\Serializer;

use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Ignore;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=ImagesRepository::class)
 */
class Images
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\ManyToOne(targetEntity=Internaute::class, cascade={"persist", "remove"}, inversedBy="images")
     */
    private $internaute;

    /**
     * @ORM\ManyToOne(targetEntity=Prestataire::class, cascade={"persist", "remove"}, inversedBy="images")
     */
    private $prestataire;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getInternaute(): ?Internaute
    {
        return $this->internaute;
    }

    public function setInternaute(?Internaute $internaute): self
    {
        $this->internaute = $internaute;

        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }


    public function setImageFile(?file $image = null): void
    {
        $this->imageFile = $image;

        if (null !== $image) {

            $this->updatedAt = new \DateTime();
        }
    }

    public function getPrestataire(): ?Prestataire
    {
        return $this->prestataire;
    }

    public function setPrestataire(?Prestataire $prestataire): self
    {
        $this->prestataire = $prestataire;

        return $this;
    }

    public function __toString()
    {
        return $this->image;
    }

    public function slug(){
        return "img/users/".$this->image;
    }
}
