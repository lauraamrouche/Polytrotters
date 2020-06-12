<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikePosteRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class LikePoste
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Poste", inversedBy="likePostes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poste;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="likePostes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trotter;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * Permet de mettre en place la date du like
     * 
     * @ORM\PrePersist
     *
     * @return void
     */
    public function prePersist() {
        if(empty($this->date)){
            $this->date = new \DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTrotter(): ?User
    {
        return $this->trotter;
    }

    public function setTrotter(?User $trotter): self
    {
        $this->trotter = $trotter;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
