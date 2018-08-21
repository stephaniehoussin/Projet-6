<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RejectRepository")
 */
class Reject
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $situation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $informations;

    /**
     * @ORM\ManyToOne(targetEntity="Spot", inversedBy="rejects")
     */
    private $spot;
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="rejects")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSituation(): ?string
    {
        return $this->situation;
    }

    public function setSituation(string $situation): self
    {
        $this->situation = $situation;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getInformations(): ?string
    {
        return $this->informations;
    }

    public function setInformations(string $informations): self
    {
        $this->informations = $informations;

        return $this;
    }

    public function getSpot()
    {
        return $this->spot;
    }

    /**
     * @param Spot $spot
     * @return Reject
      */
    public function setSpot(Spot $spot)
    {
        $this->spot = $spot;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Reject
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
}
