<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    private $park;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $barPlace;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $restaurantPlace;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $forest;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $water;



    public function getId()
    {
        return $this->id;
    }

    public function getPark(): ?string
    {
        return $this->park;
    }

    public function setPark(string $park): self
    {
        $this->park = $park;

        return $this;
    }

    public function getBarPlace(): ?string
    {
        return $this->barPlace;
    }

    public function setBarPlace(string $barPlace): self
    {
        $this->barPlace = $barPlace;

        return $this;
    }

    public function getRestaurantPlace(): ?string
    {
        return $this->restaurantPlace;
    }

    public function setRestaurantPlace(string $restaurantPlace): self
    {
        $this->restaurantPlace = $restaurantPlace;

        return $this;
    }

    public function getForest(): ?string
    {
        return $this->forest;
    }

    public function setForest(string $forest): self
    {
        $this->forest = $forest;

        return $this;
    }

    public function getWater(): ?string
    {
        return $this->water;
    }

    public function setWater(string $water): self
    {
        $this->water = $water;

        return $this;
    }
}
