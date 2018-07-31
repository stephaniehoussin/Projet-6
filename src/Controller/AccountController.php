<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Repository\SpotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Spot;

class AccountController extends Controller
{
    /**
     * @Route("/mon-compte/", name="mon-compte")
     */
    public function index()
    {
       // $em = $this->getDoctrine()->getManager();
       // $nbComments = $em->getRepository(Comment::class)->countCommentsByUser($user->getId());
        return $this->render('account/index.html.twig',array(
        //    'nbComments' => $nbComments
        ));
    }

    /**
     * @Route("mon-compte/mes-spots", name="mes-spots")
     * @param SpotRepository $spotRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function spotsByUser(SpotRepository $spotRepository)
    {
        $user = $this->getUser();
        $spots = $spotRepository->findAllSpotsByUser($user->getId());
        return $this->render('account/accountPersonalSpots.html.twig',array(
            'spots' => $spots
        ));
    }

    /**
     * @Route("mon-compte/mes-spots-favoris", name="mes-spots-favoris")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function favoritesSpotsByUser()
    {
        return $this->render('account/accountFavoritesSpots.html.twig');
    }

    /**
     * @Route("mon-compte/mes-stats", name="mes-stats")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statsByUser()
    {
        return $this->render('account/accountPersonalStats.html.twig');
    }

    /**
     * @Route("mon-compte/mes-infos", name="mes-infos")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function informationsByUser()
    {
        return $this->render('account/accountInformations.html.twig');
    }

}
