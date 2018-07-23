<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TreeRepository")
 */
class Tree
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
    private $nbTrees;
    /**
     * @var
     * @ORM\JoinColumn(name="spot", referencedColumnName="id")
     * @@ORM\ManyToOne(targetEntity="App\Entity\Spot", mappedBy="trees")
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

    public function getNbTrees(): ?int
    {
        return $this->nbTrees;
    }

    public function setNbTrees(int $nbTrees): self
    {
        $this->nbTrees = $nbTrees;

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

    public function getSpot() : Spot
    {
        return $this->spot;
    }

    public function setSpot(Spot $spot =null)
    {
        $this->spot = $spot;
        return $this;
    }
}
