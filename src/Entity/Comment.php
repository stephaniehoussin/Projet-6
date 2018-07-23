<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $report;
    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;
    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\Entity\Spot", inversedBy="comments")
     * @ORM\JoinColumn(name="spot_id", referencedColumnName="id")
     */
    private $spot;

    public function __construct()
    {
        $this->date = new \DateTime();
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

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }
    public function getSpot(): ?string
    {
        return $this->spot;
    }

    public function setSpot(string $spot): self
    {
        $this->spot = $spot;

        return $this;
    }
}
