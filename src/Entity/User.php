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
     * @ORM\OneToMany(targetEntity="App\Entity\Favorite", mappedBy="user", cascade={"remove"})
     */
    private $favorites;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user", cascade={"remove"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Love", mappedBy="user", cascade={"remove"})
     */
    private $loves;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tree", mappedBy="user", cascade={"remove"})
     */
    private $trees;




    public function __construct()
    {
       parent::__construct();
       $this->spots = new ArrayCollection();
       $this->comments = new ArrayCollection();
       $this->loves = new ArrayCollection();
       $this->favorites = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getUsername();
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


    /**
     * @return Collection|Love[]
     */
    public function getLove() : Collection
    {
        return $this->loves;
    }

    /**
     * @param Love $love
     */
    public function addLove(Love $love)
    {
        $this->loves[] = $love;
        $love->setUser($this);
    }

    /**
     * @param Love $love
     */
    public function removeLove(Love $love)
    {
        $this->loves->removeElement($love);
    }

    /**
     * @return Collection|Love[]
     */
    public function getLoves(): Collection
    {
        return $this->loves;
    }


    /**
     * @return Collection|Tree[]
     */
    public function getTree() : Collection
    {
        return $this->trees;
    }

    /**
     * @param Tree $tree
     */
    public function addTree(Tree $tree)
    {
        $this->trees[] = $tree;
        $tree->setUser($this);
    }

    /**
     * @param Tree $tree
     */
    public function removeTree(Tree $tree)
    {
        $this->trees->removeElement($tree);
    }

    /**
     * @return Collection|Tree[]
     */
    public function getTrees(): Collection
    {
        return $this->trees;
    }

    /**
     * @return Collection|Favorite[]
     */
    public function getFavorite() : Collection
    {
        return $this->favorites;
    }

    /**
     * @param Favorite $favorite
     */
    public function addFavorite(Favorite $favorite)
    {
        $this->favorites[] = $favorite;
        $favorite->setUser($this);
    }

    /**
     * @param Favorite $favorite
     */
    public function removeFavorite(Favorite $favorite)
    {
        $this->favorites->removeElement($favorite);
    }

    /**
     * @return Collection|Favorite[]
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }




}
