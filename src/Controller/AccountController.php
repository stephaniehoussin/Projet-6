<?php

namespace App\Controller;

use App\Entity\Spot;
use App\Form\ModifSpotType;
use App\Form\SpotRejectReasonType;
use App\Repository\CommentRepository;
use App\Repository\FavorisRepository;
use App\Repository\SpotRepository;
use App\Services\CommentManager;
use App\Services\PageDecoratorsService;
use App\Services\PaginationService;
use App\Services\SpotManager;
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
        $allResult = $pageDecoratorsService->countAllData();
        $nbSpotsWaiting = $spotRepository->countSpotsByWaitingStatus();
        return $this->render('account/index.html.twig',array(
            'resultByUser' => $resultByUser,
            'allResult' => $allResult,
            'nbSpotsWaiting' => $nbSpotsWaiting));
    }

    /**
     * @Route("spots-en-attente", name="spots-en-attente")
     * @param SpotRepository $spotRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allSpotsWaiting(SpotRepository $spotRepository,PaginationService $paginationService)
    {

        $spots = $spotRepository->findSpotsByWaitingStatus();
        return $this->render('account/allSpotsWaiting.html.twig',array(
            'spots' => $spots,
        ));
    }

    /**
     * @Route("choice-status/{id}/{status}", requirements={"id" = "\d+", "status" = "\d+"}, name="choice-status" )
     * @param Request $request
     * @param $id
     * @param $status
     * @param SpotRepository $spotRepository
     * @param SpotManager $spotManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function choiceStatus(Request $request,$id, $status,SpotRepository $spotRepository,SpotManager $spotManager)
    {
        $spot = $spotRepository->findOneBy(['id' => $id]);
        $user = $this->getUser();
        if($status == 2)
        {
            $spot->setStatus(Spot::STATUS_VALID);
            $spotManager->persistSpot($spot);
            $this->addFlash('success', 'Spot validé avec succès!');
            return $this->redirectToRoute('mon-compte/spots-en-attente');
        }
        if($status == 10)
        {
            $spotManager->suppressSpot($spot);
            $this->addFlash('danger', 'Vous venez de supprimer un spot!');
            return $this->redirectToRoute('mon-compte/mes-spots-en-attente');
        }
        if($status == 11)
        {
            $spotManager->suppressSpot($spot);
            $this->addFlash('danger', 'Vous venez de supprimer un spot!');
            return $this->redirectToRoute('mon-compte/mes-spots-valides');
        }
        if($status == 0)
        {
            $formReject = $this->createForm(SpotRejectReasonType::class);
            $formReject->handleRequest($request);
            if($formReject->isSubmitted() && $formReject->isValid())
            {
                $formReject->getData();
                $spot->setStatus(Spot::STATUS_REJECT);
                $spotManager->persistSpot($spot);
               // return $this->redirectToRoute('mon-compte/spots-en-attente');
            }
        }
        return $this->render('account/spotRejectedReason.html.twig',array(
            'formReject' => $formReject->createView(),
            'user' => $user
        ));
    }

    /**
     * @Route("mes-spots-valides", name="mes-spots-valides")
     * @param SpotRepository $spotRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function spotsValidedByUser(SpotRepository $spotRepository)
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
            'spots' => $spots,
        ));
    }

    /**
     * @Route("mes-spots-rejetes", name="mes-spots-rejetes")
     * @param SpotRepository $spotRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function SpotsRejected(SpotRepository $spotRepository)
    {

        $user = $this->getUser();
        $rejectedSpots = $spotRepository->findRejectedSpotsByUser($user->getId());
        return $this->render('account/spotRejected.html.twig',array(
            'rejectedSpots' => $rejectedSpots,
        ));
    }

    /**
     * @Route("spot/modification/{id}", name="spot/modification")
     * @param Request $request
     * @param $id
     * @param SpotRepository $spotRepository
     * @param SpotManager $spotManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function modifySpot(Request $request,$id,SpotRepository $spotRepository,SpotManager $spotManager)
    {
        $user = $this->getUser();
        $spot = $spotRepository->findOneBy(['id' => $id]);
        $formModify = $this->createForm(ModifSpotType::class,$spot);
        $formModify->handleRequest($request);
        if($formModify->isSubmitted() && $formModify->isValid())
        {
            if($user->hasRole('ROLE_USER'))
            {
                $spot->setStatus(1);
            }
            if($user->hasRole('ROLE_MODERATEUR'))
            {
                $spot->setStatus(2);
            }
            $spotManager->persistSpot($spot);
            return $this->redirectToRoute('mon-compte/accueil');
        }

        return $this->render('account/modifySpot.html.twig',array(
            'formModify' => $formModify->createView(),
            'spot' => $spot
        ));

    }

    /**
     * @Route("mes-spots-favoris", name="mes-spots-favoris")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function favoritesSpotsByUser(FavorisRepository $favorisRepository)
    {
         $user = $this->getUser();
         $favoris = $favorisRepository->recupFavoritesSpotsByUser($user);
        return $this->render('account/favoritesSpots.html.twig',array(
            'favoris' => $favoris,
        ));
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
    public function reportCommentsByUser(CommentRepository $commentRepository)
    {
        $user = $this->getUser();
        $commentsReportByUser = $commentRepository->recupCommentIsReportByUSer($user);
        return $this->render('account/userReportComments.html.twig',array(
            'commentsReportByUser' => $commentsReportByUser
        ));
    }

    /**
     * @Route("commentaires-signales", name="commentaires-signales")
     * @param CommentRepository $commentRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function reportAllComments(CommentRepository $commentRepository)
    {

        $commentsReport = $commentRepository->recupCommentIsReport();
        return $this->render('account/reportAllComments.html.twig',array(
            'commentsReport' => $commentsReport
        ));
    }


}

