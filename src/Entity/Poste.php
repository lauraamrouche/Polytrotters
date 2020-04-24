<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PosteRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Poste
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $trotter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionImage;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datePoste;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titrePoste;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlPoste;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTrotter(): ?string
    {
        return $this->trotter;
    }

    public function setTrotter(string $trotter): self
    {
        $this->trotter = $trotter;

        return $this;
    }

    public function getDescriptionImage(): ?string
    {
        return $this->descriptionImage;
    }

    public function setDescriptionImage(string $descriptionImage): self
    {
        $this->descriptionImage = $descriptionImage;

        return $this;
    }

    public function getDatePoste(): ?\DateTimeInterface
    {
        return $this->datePoste;
    }

    public function setDatePoste(\DateTimeInterface $datePoste): self
    {
        $this->datePoste = $datePoste;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTitrePoste(): ?string
    {
        return $this->titrePoste;
    }

    public function setTitrePoste(string $titrePoste): self
    {
        $this->titrePoste = $titrePoste;

        return $this;
    }

    public function getUrlPoste(): ?string
    {
        return $this->urlPoste;
    }

    public function setUrlPoste(string $urlPoste): self
    {
        $this->urlPoste = $urlPoste;

        return $this;
    }
}
