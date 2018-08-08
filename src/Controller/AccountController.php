<?php

namespace App\Controller;

use App\Repository\FavorisRepository;
use App\Repository\SpotRepository;
use App\Services\PageDecoratorsService;
use App\Services\SpotManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends Controller
{
    /**
     * @Route("/mon-compte/", name="mon-compte")
     * @param PageDecoratorsService $pageDecoratorsService
     * @param SpotRepository $spotRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PageDecoratorsService $pageDecoratorsService,SpotRepository $spotRepository)
    {
        $currentUser = $this->getUser();
        $resultByUser = $pageDecoratorsService->countDataByUser($currentUser->getId());
        $nbSpotsWaiting = $spotRepository->countSpotsByWaitingStatus();
        return $this->render('account/index.html.twig',array(
        'resultByUser' => $resultByUser,
            'nbSpotsWaiting' => $nbSpotsWaiting));
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
     * @Route("mon-compte/spots-en-attente", name="spots-en-attente")
     * @param SpotRepository $spotRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allSpotsWaiting(SpotRepository $spotRepository)
    {
        $spots = $spotRepository->findSpotsByWaitingStatus();
        return $this->render('account/allSpotsWaiting.html.twig',array(
            'spots' => $spots
        ));
    }

    /**
     * @Route("mon-compte/choice-status/{id}/{status}", requirements={"id" = "\d+", "status" = "\d+"}, name="choice-status" )
     * @param $id
     * @param $status
     * @param SpotRepository $spotRepository
     * @param SpotManager $spotManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function choiceStatus($id, $status, SpotRepository $spotRepository,SpotManager $spotManager)
    {
        $spot = $spotRepository->findOneBy(['id' => $id]);
        if($status == 2)
        {
            $spot->setStatus(2);
            $spotManager->persistSpot($spot);

            return $this->redirectToRoute('mon-compte');
        }
        if($status == 0)
        {
            $spot->setStatus(0);
            $spotManager->persistSpot($spot);
            return $this->redirectToRoute('mon-compte');
        }
    }

    /**
     * @Route("mon-compte/mes-spots-favoris", name="mes-spots-favoris")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function favoritesSpotsByUser(FavorisRepository $favorisRepository)
    {
        return $this->render('account/favoritesSpots.html.twig');
    }

    /**
     * @Route("mon-compte/mes-infos", name="mes-infos")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function informationsByUser(SpotManager $spotManager,Request $request)
    {
        $user = $this->getUser();
        return $this->render('account/informations.html.twig',array(
            'user' => $user,
        ));
    }

    /**
     * @Route("mon-compte/mes-commentaires-signales", name="mes-commentaires-signales")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reportCommentsByUser()
    {
        return $this->render('account/userReportComments.html.twig');
    }

    /**
     * @Route("mon-compte/commentaires-signales", name="commentaires-signales")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reportAllComments()
    {
        return $this->render('account/reportAllComments.html.twig');
    }
}
