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

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function save(Comment $comment, User $user, Spot $spot){

        $comment->setReport(Comment::COMMENT_IS_REPORT);
        $comment->setUser($user);
        $comment->setSpot($spot);
        $this->em->persist($comment);
        $this->em->flush();
    }

    public function suppressComment($comment)
    {
        $this->em->remove($comment);
        $this->em->flush();
    }

}