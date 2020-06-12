<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentaireRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Commentaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Poste", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poste;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="yes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auteur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LikeCommentaire", mappedBy="commentaire", orphanRemoval=true)
     */
    private $likeCommentaires;

    public function __construct()
    {
        $this->likeCommentaires = new ArrayCollection();
    }


    /**
     * Retourne si l'user like le commentaire ou pas
     *
     * @param User $user
     * @return boolean
     */
    function isLikedByUser(User $user): bool
    {
        if(is_null($user)){
            return false;
        }
        foreach ($this->likeCommentaires as $like) {
            if ($like->getTrotter() === $user) {
                return true;
            }
        }
        return false;
    }

    /**
     * Permet de mettre en place la date de création
     * 
     * @ORM\PrePersist
     *
     * @return void
     */
    public function prePersist()
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getPoste(): ?Poste
    {
        return $this->poste;
    }

    public function setPoste(?Poste $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * @return Collection|LikeCommentaire[]
     */
    public function getLikeCommentaires(): Collection
    {
        return $this->likeCommentaires;
    }

    public function addLikeCommentaire(LikeCommentaire $likeCommentaire): self
    {
        if (!$this->likeCommentaires->contains($likeCommentaire)) {
            $this->likeCommentaires[] = $likeCommentaire;
            $likeCommentaire->setCommentaire($this);
        }

        return $this;
    }

    public function removeLikeCommentaire(LikeCommentaire $likeCommentaire): self
    {
        if ($this->likeCommentaires->contains($likeCommentaire)) {
            $this->likeCommentaires->removeElement($likeCommentaire);
            // set the owning side to null (unless already changed)
            if ($likeCommentaire->getCommentaire() === $this) {
                $likeCommentaire->setCommentaire(null);
            }
        }

        return $this;
    }
}
