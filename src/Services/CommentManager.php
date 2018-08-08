<?php

namespace App\Services;

use App\Entity\Comment;
use App\Entity\Spot;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class CommentManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }




    public function save(Comment $comment, User $user, Spot $spot){

        $comment->setUser($user);
        $comment->setSpot($spot);
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }
}