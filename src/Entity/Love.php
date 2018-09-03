<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LoveRepository")
 */
class Love
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Spot", inversedBy="loves")
     */
    private $spot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="loves")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Spot
     */
    public function getSpot()
    {
        return $this->spot;
    }

    /**
     * @param Spot $spot
     * @return Love
     */
    public function setSpot(Spot $spot)
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
