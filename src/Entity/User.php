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

    /**
     * @var
     * @ORM\OneToMany(targetEntity="App\Entity\Opinion", mappedBy="user", cascade={"remove"})
     */
    private $opinions;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user", cascade={"remove"})
     */
    private $comments;




    public function __construct()
    {
       parent::__construct();
       $this->spots = new ArrayCollection();
       $this->comments = new ArrayCollection();
       $this->opinions = new ArrayCollection();
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

    /**
     * @return Collection|Spot[]
     */
    public function getSpots(): Collection
    {
        return $this->spots;
    }


    /**
     * @return Collection|Opinion[]
     */
    public function getOpinion() : Collection
    {
        return $this->opinions;
    }

    /**
     * @param Opinion $opinion
     */
    public function addOpinion(Opinion $opinion)
    {
        $this->opinions[] = $opinion;
        $opinion->setUser($this);
    }

    /**
     * @param Opinion $opinion
     */
    public function removeOpinion(Opinion $opinion)
    {
        $this->opinions->removeElement($opinion);
    }

    /**
     * @return Collection|Opinion[]
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }


    /**
     * @return Collection|Comment[]
     */
    public function getComment() : Collection
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
        $comment->setUser($this);
    }

    /**
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

}
