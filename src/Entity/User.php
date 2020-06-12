<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *  fields={"email"},
 *  message="Cette adresse mail est déjà utilisée par un autre utilisateur"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez renseignez un pseudo")
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez renseignez un nom")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="Veuillez un email valide !")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(message="Veuillez une URL valide pour votre avatar!")
     */
    private $avatarUser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $passwd;

    /**
     * @Assert\EqualTo(propertyPath="passwd", message="Le mot de passe ne correspond à celui entré précedemment")
     *
     */
    public $passwdConfirm;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=10, minMessage="Veuillez vous décrire en plus de 10 caractères !")
     */
    private $descriptionUser;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Poste", mappedBy="trotter")
     */
    private $postes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="auteur", orphanRemoval=true)
     */
    private $yes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LikePoste", mappedBy="trotter", orphanRemoval=true)
     */
    private $likePostes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LikeCommentaire", mappedBy="trotter")
     */
    private $likeCommentaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Follower", mappedBy="follower", orphanRemoval=true)
     */
    private $followers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Follower", mappedBy="followed", orphanRemoval=true)
     */
    private $followedBy;

    /**
     * Retourne si l'user follow cet utilisateur ou pas
     *
     * @param User $user
     * @return boolean
     */
    function isFollowedByUser(User $user): bool
    {
        if (is_null($user)) {
            return false;
        }
        foreach ($this->followedBy as $follow) {
            if ($follow->getFollower() === $user) {
                return true;
            }
        }
        return false;
    }

    public function __construct()
    {
        $this->postes = new ArrayCollection();
        $this->yes = new ArrayCollection();
        $this->likePostes = new ArrayCollection();
        $this->likeCommentaires = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->followedBy = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAvatarUser(): ?string
    {
        return $this->avatarUser;
    }

    public function setAvatarUser(string $avatarUser): self
    {
        $this->avatarUser = $avatarUser;

        return $this;
    }

    public function getPasswd(): ?string
    {
        return $this->passwd;
    }

    public function setPasswd(string $passwd): self
    {
        $this->passwd = $passwd;

        return $this;
    }

    public function getDescriptionUser(): ?string
    {
        return $this->descriptionUser;
    }

    public function setDescriptionUser(string $descriptionUser): self
    {
        $this->descriptionUser = $descriptionUser;

        return $this;
    }

    /**
     * @return Collection|Poste[]
     */
    public function getPostes(): Collection
    {
        return $this->postes;
    }

    public function addPoste(Poste $poste): self
    {
        if (!$this->postes->contains($poste)) {
            $this->postes[] = $poste;
            $poste->setTrotter($this);
        }

        return $this;
    }

    public function removePoste(Poste $poste): self
    {
        if ($this->postes->contains($poste)) {
            $this->postes->removeElement($poste);
            // set the owning side to null (unless already changed)
            if ($poste->getTrotter() === $this) {
                $poste->setTrotter(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        return $this->passwd;
    }

    public function getSalt(){}

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials(){}

    /**
     * @return Collection|Commentaire[]
     */
    public function getYes(): Collection
    {
        return $this->yes;
    }

    public function addYe(Commentaire $ye): self
    {
        if (!$this->yes->contains($ye)) {
            $this->yes[] = $ye;
            $ye->setAuteur($this);
        }

        return $this;
    }

    public function removeYe(Commentaire $ye): self
    {
        if ($this->yes->contains($ye)) {
            $this->yes->removeElement($ye);
            // set the owning side to null (unless already changed)
            if ($ye->getAuteur() === $this) {
                $ye->setAuteur(null);
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
            $likePoste->setTrotter($this);
        }

        return $this;
    }

    public function removeLikePoste(LikePoste $likePoste): self
    {
        if ($this->likePostes->contains($likePoste)) {
            $this->likePostes->removeElement($likePoste);
            // set the owning side to null (unless already changed)
            if ($likePoste->getTrotter() === $this) {
                $likePoste->setTrotter(null);
            }
        }

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
            $likeCommentaire->setTrotter($this);
        }

        return $this;
    }

    public function removeLikeCommentaire(LikeCommentaire $likeCommentaire): self
    {
        if ($this->likeCommentaires->contains($likeCommentaire)) {
            $this->likeCommentaires->removeElement($likeCommentaire);
            // set the owning side to null (unless already changed)
            if ($likeCommentaire->getTrotter() === $this) {
                $likeCommentaire->setTrotter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Follower[]
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(Follower $follower): self
    {
        if (!$this->followers->contains($follower)) {
            $this->followers[] = $follower;
            $follower->setFollower($this);
        }

        return $this;
    }

    public function removeFollower(Follower $follower): self
    {
        if ($this->followers->contains($follower)) {
            $this->followers->removeElement($follower);
            // set the owning side to null (unless already changed)
            if ($follower->getFollower() === $this) {
                $follower->setFollower(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Follower[]
     */
    public function getFollowedBy(): Collection
    {
        return $this->followedBy;
    }

    public function addFollowedBy(Follower $followedBy): self
    {
        if (!$this->followedBy->contains($followedBy)) {
            $this->followedBy[] = $followedBy;
            $followedBy->setFollowed($this);
        }

        return $this;
    }

    public function removeFollowedBy(Follower $followedBy): self
    {
        if ($this->followedBy->contains($followedBy)) {
            $this->followedBy->removeElement($followedBy);
            // set the owning side to null (unless already changed)
            if ($followedBy->getFollowed() === $this) {
                $followedBy->setFollowed(null);
            }
        }

        return $this;
    }

}
