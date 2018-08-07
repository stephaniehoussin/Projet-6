<?php
namespace App\Services;
use App\Entity\Comment;
use App\Entity\Favoris;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Spot;
use App\Entity\Opinion;
use App\Entity\Love;
use App\Entity\Tree;
use App\Entity\User;


class SpotManager

{

    public function __construct(EntityManagerInterface $em)
    {
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

    public function initLove()
{
    $love = new Love();
    return $love;
}

    public function initTree()
    {
        $tree = new Tree();
        return $tree;
    }

    public function initFavoris()
    {
        $favoris = new Favoris();
        return $favoris;
    }


    public function persistSpot(Spot $spot)
    {
        $this->em->persist($spot);
        $this->em->flush();
    }

    public function persistUser(User $user)
    {
        $this->em->persist($user);
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

    public function persistFavoris(Favoris $favoris)
    {
        $this->em->persist($favoris);
        $this->em->flush();
    }
    public function persistTree(Tree $tree)
    {
        $this->em->persist($tree);
        $this->em->flush();

    }

    public function persistLove(Love $love)
    {
        $this->em->persist($love);
        $this->em->flush();
    }

}