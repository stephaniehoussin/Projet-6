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
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function commentReport(Comment $comment)
    {


    }
    public function save(Comment $comment){

       // $comment->setReport(Comment::COMMENT_IS_REPORT);
        $this->em->persist($comment);
        $this->em->flush();
       //
      //  $comment->setUser($user);
      //  $comment->setSpot($spot);
    }

    public function suppressComment($comment)
    {
        $this->em->remove($comment);
        $this->em->flush();
    }

}