<?php
namespace App\Services;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Spot;
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


    public function makeSpotManager(Spot $spot)
    {

    }
}