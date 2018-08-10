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

    const COMMENT_IS_NO_REPORT = 0;
    const COMMENT_IS_REPORT  = 1;
    const COMMENT_IS_ALREADY_REPORT = 2;
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
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\Range(min = 0, max = 2)
     * 0 = noSignal, 1 = signal, 2 = alreadySignal
     */
    private $report = self::COMMENT_IS_NO_REPORT;
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

}

