<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PosteRepository")
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
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datePoste;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="postes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trotter;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo", mappedBy="poste", cascade={"remove"})
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="poste", orphanRemoval=true)
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LikePoste", mappedBy="poste", orphanRemoval=true)
     */
    private $likePostes;

    /**
     * Retourne si l'user like le poste ou pas
     *
     * @param User $user
     * @return boolean
     */
    function isLikedByUser(User $user): bool
    {
        if (is_null($user)) {
            return false;
        }
        foreach ($this->likePostes as $like) {
            if ($like->getTrotter() === $user) {
                return true;
            }
        }
        return false;
    }

    public function firstPhoto()
    {
        return $this->getPhotos()->first();
    }

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->likePostes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getDatePoste(): ?\DateTimeInterface
    {
        return $this->datePoste;
    }

    public function setDatePoste(\DateTimeInterface $datePoste): self
    {
        $this->datePoste = $datePoste;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTrotter(): ?User
    {
        return $this->trotter;
    }

    public function setTrotter(?User $trotter): self
    {
        $this->trotter = $trotter;

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setPoste($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getPoste() === $this) {
                $photo->setPoste(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setPoste($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getPoste() === $this) {
                $commentaire->setPoste(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LikePoste[]
     */
    public function getLikePostes(): Collection
    {
        return $this->likePostes;
    }

    public function addLikePoste(LikePoste $likePoste): self
    {
        if (!$this->likePostes->contains($likePoste)) {
            $this->likePostes[] = $likePoste;
            $likePoste->setPoste($this);
        }

        return $this;
    }

    public function removeLikePoste(LikePoste $likePoste): self
    {
        if ($this->likePostes->contains($likePoste)) {
            $this->likePostes->removeElement($likePoste);
            // set the owning side to null (unless already changed)
            if ($likePoste->getPoste() === $this) {
                $likePoste->setPoste(null);
            }
        }

        return $this;
    }
}
