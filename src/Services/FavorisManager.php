<?php

namespace App\Services;

use App\Entity\Favoris;
use App\Entity\Spot;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class FavorisManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function save(Favoris $favoris, User $user, Spot $spot)
    {

        $favoris->setUser($user);
        $favoris->setSpot($spot);
        $this->entityManager->persist($favoris);
        $this->entityManager->flush();
    }
}