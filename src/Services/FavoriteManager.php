<?php

namespace App\Services;

use App\Entity\Comment;
use App\Entity\Favorite;
use App\Entity\Spot;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class FavoriteManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function save(Favorite $favorite, User $user, Spot $spot)
    {


        $favorite->setUser($user);
        $favorite->setSpot($spot);
        $this->entityManager->persist($favorite);
        $this->entityManager->flush();
    }

}