<?php
namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Reject;
use App\Entity\User;
use App\Entity\Spot;


class RejectManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Reject $reject, User $user, Spot $spot)
    {
        $reject->setUser($user);
        $reject->setSpot($spot);
        $this->entityManager->persist($reject);
        $this->entityManager->flush();
    }
}