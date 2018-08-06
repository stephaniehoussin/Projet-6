<?php
namespace App\Services;
use App\Entity\Comment;
use App\Repository\OpinionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Spot;
use App\Entity\Opinion;
use App\Entity\User;
use App\Entity\Love;
use App\Entity\Tree;
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

    public function initLike()
{
    $love = new Love();
    return $love;
}

    public function initTree()
    {
        $tree = new Tree();
        return $tree;
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
    public function persistTree(Tree $tree)
    {
        $this->em->persist($tree);
        $this->em->flush();

    }

    public function persistLike(Love $like)
{
    $this->em->persist($like);
    $this->em->flush();
}

}