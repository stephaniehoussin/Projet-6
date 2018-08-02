<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Spot", mappedBy="category", cascade={"remove"})
     */
    private $spots;

    public function __construct()
    {
        $this->spots = new ArrayCollection();
    }


    public function __toString()
    {
        return $this->getName();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @return Collection|Spot[]
     */
    public function getSpot() : Collection
    {
        return $this->spots;
    }

    /**
     * @return Collection|Spot[]
     */
    public function getSpots() : Collection
    {
        return $this->spots;
    }

    /**
     * @param Spot $spot
     */
    public function addSpot(Spot $spot)
    {
        $this->spots[] = $spot;
        $spot->setCategory($this);
    }

    /**
     * @param Spot $spot
     */
    public function removeSpot(Spot $spot)
    {
        $this->spots->removeElement($spot);
    }


}
