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
     * @ORM\ManyToOne(targetEntity="App\Entity\Spot", inversedBy="trees")
     */
    private $spot;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="trees")
     */
    private $user;

    public function getId()
    {
        return $this->id;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function getSpot()
    {
        return $this->spot;
    }

    /**
     * @param Spot $spot
     * @return Tree
     */
    public function setSpot(Spot $spot)
    {
        $this->spot = $spot;
        return $this;
    }
}
