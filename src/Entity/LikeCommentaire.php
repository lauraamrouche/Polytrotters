<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikeCommentaireRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class LikeCommentaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commentaire", inversedBy="likeCommentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="likeCommentaires")
     */
    private $trotter;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * Permet de mettre en place la date du like
     * 
     * @ORM\PrePersist
     *
     * @return void
     */
    public function prePersist() {
        if(empty($this->createdAt)){
            $this->createdAt = new \DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?Commentaire
    {
        return $this->commentaire;
    }

    public function setCommentaire(?Commentaire $commentaire): self
    {
        $this->commentaire = $commentaire;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
