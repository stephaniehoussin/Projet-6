<?php

namespace App\Services;

use App\Entity\love;
use App\Entity\Spot;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class LoveManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function save(Love $love, User $user, Spot $spot)
    {

        $love->setUser($user);
        $love->setSpot($spot);
        $this->entityManager->persist($love);
        $this->entityManager->flush();
    }
}