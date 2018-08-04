<?php
namespace App\Services;
use App\Entity\Comment;
use App\Repository\OpinionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Spot;
use App\Entity\Opinion;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SpotManager

{

    public function __construct(SessionInterface $session,EntityManagerInterface $em)
    {
        $this->session = $session;
        $this->em = $em;
    }

    public function initSpot()
    {
        $spot = new Spot();
        return $spot;
    }

    public function initComment()
    {
        $comment = new Comment();
        return $comment;
    }


    public function persistSpot(Spot $spot)
    {
        $this->em->persist($spot);
        $this->em->flush();
    }

    public function persistComment(Comment $comment)
    {
        $this->em->persist($comment);
        $this->em->flush();
    }

    public function persistOpinion(Opinion $opinion)
    {
        $this->em->persist($opinion);
        $this->em->flush();
    }
}