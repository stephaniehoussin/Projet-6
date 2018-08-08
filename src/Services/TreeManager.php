<?php

namespace App\Services;

use App\Entity\Tree;
use App\Entity\Spot;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class TreeManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function save(Tree $tree, User $user, Spot $spot)
    {

        $tree->setUser($user);
        $tree->setSpot($spot);
        $this->entityManager->persist($tree);
        $this->entityManager->flush();
    }
}