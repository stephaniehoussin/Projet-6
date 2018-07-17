<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TreeRepository")
 */
class Tree
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbTrees;

    public function getId()
    {
        return $this->id;
    }

    public function getNbTrees(): ?int
    {
        return $this->nbTrees;
    }

    public function setNbTrees(int $nbTrees): self
    {
        $this->nbTrees = $nbTrees;

        return $this;
    }
}
