<?php

namespace App\Controller;

use App\Repository\SpotRepository;
use App\Repository\UserRepository;
use App\Services\PageDecoratorsService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller
{
    /**
     * @Route("/mon-compte/", name="mon-compte")
     */
    public function index()
    {
        return $this->render('account/index.html.twig',array(
        ));
    }

    /**
     * @Route("mon-compte/mes-spots-valides", name="mes-spots-valides")
     * @param SpotRepository $spotRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function spotsValidedByUser(SpotRepository $spotRepository)
    {
        $user = $this->getUser();
        $spots = $spotRepository->findAllSpotsByUser($user->getId());
        return $this->render('account/spotsAccepted.html.twig',array(
            'spots' => $spots,
        ));
    }

    /**
     * @Route("mon-compte/mes-spots-en-attente", name="mes-spots-en-attente")
     * @param SpotRepository $spotRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function spotsWaitingByUser(SpotRepository $spotRepository)
    {
        $user = $this->getUser();
        $spots = $spotRepository->findAllSpotsByUser($user->getId());
        return $this->render('account/spotsWaiting.html.twig',array(
            'spots' => $spots
        ));
    }

    /**
     * @Route("mon-compte/mes-spots-favoris", name="mes-spots-favoris")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function favoritesSpotsByUser()
    {
        return $this->render('account/favoritesSpots.html.twig');
    }

    /**
     * @Route("mon-compte/mes-stats", name="mes-stats")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statsByUser(PageDecoratorsService $pageDecoratorsService)
    {
        $result = $pageDecoratorsService->recupAllData();
        return $this->render('account/stats.html.twig',array(
            'result' => $result
        ));
    }

    /**
     * @Route("mon-compte/mes-infos", name="mes-infos")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function informationsByUser(UserRepository $userRepository)
    {
        return $this->render('account/informations.html.twig');
    }

    /**
     * @Route("mon-compte/commentaires-signales", name="commentaires-signales")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reportCommentsByUser()
    {
        return $this->render('account/reportComments.html.twig');
    }
}
