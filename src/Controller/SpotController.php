<?php

namespace App\Controller;

use App\Form\commentType;
use App\Form\FavorisType;
use App\Form\LoveType;
use App\Entity\Love;
use App\Form\SpotFilterType;
use App\Form\spotType;
use App\Form\TreeType;
use App\Repository\CommentRepository;
use App\Repository\LoveRepository;
use App\Repository\SpotRepository;
use App\Repository\TreeRepository;
use App\Services\PageDecoratorsService;
use App\Services\SpotManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Spot;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SpotController extends Controller
{
    /**
     * @Route("accueil/je-spote", name="je-spote")
     * @param SpotManager $spotManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function makeSpot(SpotManager $spotManager,Request $request)
    {
        $spot = $spotManager->initSpot();
        $form = $this->createForm(spotType::class, $spot);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $currentUser = $this->getUser();
            if($currentUser->hasRole('ROLE_MODERATEUR'))
            {
                $spot->setStatus(2);
            }
            $spot->setUser($currentUser);
            $spotManager->persistSpot($spot);
            return $this->redirectToRoute('je-cherche-un-spot', ['page' => 1]);
        }
        return $this->render('spot/makeSpot.html.twig', [
            'formSpot' => $form->createView(),
        ]);
    }

    /**
     * @Route("accueil/je-cherche-un-spot/{page}", requirements={"page" = "\d+"} , name="je-cherche-un-spot")
     * @param SpotRepository $spotRepository
     * @param $page
     * @return Response
     */
    public function searchSpot(SpotRepository $spotRepository,$page)
    {
        $form = $this->createForm(SpotFilterType::class);
        $spots = $spotRepository->findAllSpotsByDate($page);
        $nbSpots = $spotRepository->countAllSpots();
        $nbPages = ceil($nbSpots / 12);
        if($page != 1 && $page > $nbPages)
        {
            throw new NotFoundHttpException("La page n'existe pas");
        }
        $pagination = [
            'page' => $page,
            'nbPages' => $nbPages,
            'nbSpots' => $nbSpots
        ];
        return $this->render('spot/searchSpot.html.twig', array(
            'spots' => $spots,
            'pagination' => $pagination,
            'formFilter' => $form->createView()
        ));
    }

    /**
     * @Route("accueil/spot/{id}", name="spot")
     * @param PageDecoratorsService $pageDecoratorsService
     * @param SpotManager $spotManager
     * @param SpotRepository $spotRepository
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function showOneSpot(PageDecoratorsService $pageDecoratorsService,SpotManager $spotManager, SpotRepository $spotRepository, Request $request,  $id)
    {

        $spot = $spotRepository->findOneBy(['id' => $id]);
        $resultBySpot = $pageDecoratorsService->countDataBySpot($spot->getId());
        $comment = $spotManager->initComment();
        $formComment = $this->createForm(commentType::class, $comment);
        $formComment->handleRequest($request);
        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $currentUser = $this->getUser();
            $comment->setSpot($spot);
            $comment->setUser($currentUser);
            $spotManager->persistComment($comment);
        }

        $love = $spotManager->initLove();
        $formLove = $this->createForm(LoveType::class, $love);
        $formLove->handleRequest($request);
        if($formLove->isSubmitted() && $formLove->isValid())
        {
                $currentUser = $this->getUser();
                $love->setSpot($spot);
                $love->setUser($currentUser);
                $spotManager->persistLove($love);

        }

        $tree = $spotManager->initTree();
        $formTree = $this->createForm(TreeType::class, $tree);
        $formTree->handleRequest($request);
        if($formTree->isSubmitted() && $formTree->isValid())
        {
            $currentUser = $this->getUser();
            $tree->setSpot($spot);
            $tree->setUser($currentUser);
            $spotManager->persistTree($tree);
        }

        $favoris = $spotManager->initFavoris();
        $formFavoris = $this->createForm(FavorisType::class, $favoris);
        $formFavoris->handleRequest($request);
        if($formFavoris->isSubmitted() && $formFavoris->isValid())
        {
            $currentUser = $this->getUser();
            $favoris->setSpot($spot);
            $favoris->setUser($currentUser);
            $spotManager->persistFavoris($favoris);
        }
        return $this->render('spot/showOneSpot.html.twig', array(
            'spot' => $spot,
          //  'comment' => $comment,
            'formComment' => $formComment->createView(),
            'formLove' => $formLove->createView(),
            'formTree' => $formTree->createView(),
            'formFavoris' => $formFavoris->createView(),
         //   'favoris' => $favoris,
          //  'love' => $love,
         //   'tree' => $tree,
            'resultBySpot' => $resultBySpot
        ));
    }

}

