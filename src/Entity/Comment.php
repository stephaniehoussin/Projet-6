<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="parent", cascade={"persist", "remove"})
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment", inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\Range(min = 0, max = 2)
     * 0 = noSignal, 1 = signal, 2 = alreadySignal
     */
    private $report;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     */
    private $user;
    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\Entity\Spot", inversedBy="comments")
     */
    private $spot;


    public function __construct()
    {
        $this->date = new \DateTime();
        $this->report = 0;
        $this->children = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getMessage();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getReport(): ?bool
    {
        return $this->report;
    }

    public function setReport(bool $report): self
    {
        $this->report = $report;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
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
     * @return Comment
     */
    public function setSpot(Spot $spot)
    {
        $this->spot = $spot;

        return $this;
    }
    /**
     * Set parent
     *
     * @param string $parent
     *
     * @return Comment
     */
    public function setParent(Comment $parent)
    {
        $this->parent = $parent;
        $parent->addChild($this);
        return $this;
    }
    /**
     * Get parent
     *
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * Add child
     *
     * @param Comment $child
     *
     * @return Comment
     */
    public function addChild(Comment $child)
    {
        $this->children[] = $child;
        return $this;
    }
    /**
     * Remove child
     *
     * @param Comment $child
     */
    public function removeChild(Comment $child)
    {
        $this->children->removeElement($child);
    }
    /**
     * Get children
     *
     * @return Collection
     */
    public function getChildren()
    {
        return $this->children;
    }





}

