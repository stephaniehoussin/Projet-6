<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikeRepository")
 */
class Like
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbLikes;

    /**
     * @var
     * @ORM\JoinColumn(name="spot", referencedColumnName="id")
     * @@ORM\ManyToOne(targetEntity="App\Entity\Spot", mappedBy="likes")
     */
    private $spot;

    /**
     * @var
     * @ORM\OneToOne(targetEntity="App\Entity\User")
     */
    private $user;

    public function getId()
    {
        return $this->id;
    }

    public function getNbLikes(): ?int
    {
        return $this->nbLikes;
    }

    public function setNbLikes(int $nbLikes): self
    {
        $this->nbLikes = $nbLikes;

        return $this;
    }

    public function getSpot() : Spot
    {
        return $this->spot;
    }

    public function setSpot(Spot $spot =null)
    {
        $this->spot = $spot;
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

}
