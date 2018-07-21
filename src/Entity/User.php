<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @var
     * @ORM\OneToMany(targetEntity="App\Entity\Spot", mappedBy="user", cascade={"remove"})
     */
    private $spots;


    public function __construct()
    {
       parent::__construct();
       $this->spots = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return Collection|Spot[]
     */
    public function getSpot() : Collection
    {
        return $this->spots;
    }

    /**
     * @param Spot $spot
     */
    public function addSpot(Spot $spot)
    {
        $this->spots[] = $spot;
        $spot->setUser($this);
    }

    /**
     * @param Spot $spot
     */
    public function removeSpot(Spot $spot)
    {
        $this->spots->removeElement($spot);
    }
}
