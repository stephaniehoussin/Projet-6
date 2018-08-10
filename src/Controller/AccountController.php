<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Entity\Spot;
use App\Form\ModifSpotType;
use App\Repository\FavorisRepository;
use App\Repository\SpotRepository;
use App\Services\PageDecoratorsService;
use App\Services\SpotManager;
use App\Services\StatusManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccountController
 * @package App\Controller
 * @Route("mon-compte/", name="mon-compte/")
 */
class AccountController extends Controller
{
    /**
     * @Route("accueil", name="accueil")
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
     * @Route("mes-spots-valides", name="mes-spots-valides")
     * @param SpotRepository $spotRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function spotsValidedByUser(SpotRepository $spotRepository,PageDecoratorsService $pageDecoratorsService)
    {
        $user = $this->getUser();
        $spots = $spotRepository->findValidedSpotsByUser($user->getId());
        return $this->render('account/spotsAccepted.html.twig',array(
            'spots' => $spots,
        ));
    }

    /**
     * @Route("mes-spots-en-attente", name="mes-spots-en-attente")
     * @param SpotRepository $spotRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function spotsWaitingByUser(SpotRepository $spotRepository)
    {
        $user = $this->getUser();
        $spots = $spotRepository->findWaitingSpotsByUser($user->getId());
        return $this->render('account/spotsWaiting.html.twig',array(
            'spots' => $spots
        ));
    }

    /**
     * @Route("mes-spots-favoris", name="mes-spots-favoris")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function favoritesSpotsByUser(FavorisRepository $favorisRepository)
    {
       // $user = $this->getUser();
       // $favoris = $favorisRepository->recupFavoritesSpotsByUser($user);
        return $this->render('account/favoritesSpots.html.twig');
    }

    /**
     * @Route("spots-en-attente", name="spots-en-attente")
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
     * @Route("choice-status/{id}/{status}", requirements={"id" = "\d+", "status" = "\d+"}, name="choice-status" )
     * @param $id
     * @param $status
     * @param SpotRepository $spotRepository
     * @param SpotManager $spotManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function choiceStatus($id, $status,StatusManager $statusManager ,SpotRepository $spotRepository,SpotManager $spotManager)
    {
        $spot = $spotRepository->findOneBy(['id' => $id]);
        if($status == 2)
        {
            $spot->setStatus(Spot::STATUS_VALID);
            $spotManager->persistSpot($spot);

            return $this->redirectToRoute('mon-compte/accueil');
        }
        if($status == 0)
        {
            $spot->setStatus(Spot::STATUS_REJECT);
            $spotManager->persistSpot($spot);
            return $this->redirectToRoute('mon-compte/accueil');
        }
    }



    /**
     * @Route("mes-infos", name="mes-infos")
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
     * @Route("mes-commentaires-signales", name="mes-commentaires-signales")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reportCommentsByUser()
    {
        return $this->render('account/userReportComments.html.twig');
    }

    /**
     * @Route("commentaires-signales", name="commentaires-signales")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reportAllComments()
    {
        return $this->render('account/reportAllComments.html.twig');
    }

    /**
     * @Route("Je-modifie-mon-spot", name="je-modifie-mon-spot")
     */
    public function modifySpot(Request $request)
    {
        /* $spot = new Spot();
        $formModifySpot = $this->createForm(ModifSpotType::class);
        $formModifySpot->handleRequest($request);
        if($formModifySpot->isSubmitted() && $formModifySpot->isValid())
        {
            return $this->redirectToRoute('account/mon-compte');
        }
       return $this->render('account/modifySpot.html.twig',array(
           '$formModifySpot' => $formModifySpot
       ));*/
    }
}
