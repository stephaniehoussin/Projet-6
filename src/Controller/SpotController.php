<?php

namespace App\Controller;

use App\Entity\Spot;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\FavoriteType;
use App\Form\LoveType;
use App\Form\SpotFilterType;
use App\Form\SpotType;
use App\Form\TreeType;
use App\Repository\CommentRepository;
use App\Repository\FavoriteRepository;
use App\Repository\LoveRepository;
use App\Repository\SpotRepository;
use App\Repository\TreeRepository;
use App\Services\CommentManager;
use App\Services\FavoriteManager;
use App\Services\LoveManager;
use App\Services\PageDecoratorsService;
use App\Services\PaginationService;
use App\Services\SpotManager;
use App\Services\TreeManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SpotController
 * @package App\Controller
 * @Route("accueil/", name="accueil/")
 */
class SpotController extends Controller
{
    /**
     * @Route("je-spote", name="je-spote")
     * @param SpotManager $spotManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function makeSpot(SpotManager $spotManager, Request $request)
    {
        $spot = $spotManager->initSpot();
        $formSpot = $this->createForm(SpotType::class,$spot);
        $formSpot->handleRequest($request);
        if ($formSpot->isSubmitted() && $formSpot->isValid())
        {
            $spotManager->save($spot,$this->getUser());
            return $this->redirectToRoute('accueil/je-cherche-un-spot', ['page' => 1]);
        }
        return $this->render('home/makeSpot.html.twig', [
            'formSpot' => $formSpot->createView(),
        ]);
    }

    /**
     * @Route("je-cherche-un-spot/{page}", requirements={"page" = "\d+"} , name="je-cherche-un-spot")
     * @param PaginationService $paginationService
     * @param SpotRepository $spotRepository
     * @param $page
     * @param Request $request
     * @return Response
     */
    public function searchSpot(PaginationService $paginationService,SpotRepository $spotRepository, $page, Request $request)
    {
        $spots = $spotRepository->findAllSpotsByDate($page);
        $formFilter = $this->createForm(SpotFilterType::class);
        $formFilter->handleRequest($request);

        if($formFilter->isSubmitted() && $formFilter->isValid())
        {
             $data = $formFilter->getData();
            $spots = $spotRepository->findSpotsByUserAndCategory($data['user'],$data['category'],$page);
            if(!$spots)
            {
                $this->addFlash('success','Aucun résultat pour le moment !');
            }
        }
        $pagination = $paginationService->paginationHome($page);
        return $this->render('home/searchSpot.html.twig', array(
            'spots' => $spots,
            'pagination' => $pagination,
            'formFilter' => $formFilter->createView(),
        ));
    }

    /**
     * @Route("spot/{id}", name="spot")
     * @param $id
     * @param SpotRepository $spotRepository
     * @param CommentRepository $commentRepository
     * @param PageDecoratorsService $pageDecoratorsService
     * @param CommentManager $commentManager
     * @param Request $request
     * @param Spot $spot
     * @return Response
     */
    public function showOneSpot($id,SpotRepository $spotRepository,CommentRepository $commentRepository,PageDecoratorsService $pageDecoratorsService, CommentManager $commentManager, Request $request, Spot $spot)
    {
        $resultBySpot = $pageDecoratorsService->countDataBySpot($spot->getId());
        $formLove = $this->createForm(LoveType::class);
        $formTree = $this->createForm(TreeType::class);
        $formFavoris = $this->createForm(FavoriteType::class);
        $spot = $spotRepository->find($id);
        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class,$comment);
        $formComment->handleRequest($request);
        if ($formComment->isSubmitted() && $formComment->isValid())
        {
            $user = $this->getUser();
            $comment->setSpot($spot);
            $comment->setUser($user);
            $commentManager->save($comment);
        }

        $report = $commentRepository->recupCommentIsReport();

        return $this->render('home/showOneSpot.html.twig', array(
            'spot' => $spot,
            'comment' => $comment,
            'formComment' => $formComment->createView(),
            'formLove' => $formLove->createView(),
            'formTree' => $formTree->createView(),
            'formFavoris' => $formFavoris->createView(),
            'report' => $report,
            'resultBySpot' => $resultBySpot,
        ));
    }


    /**
     * @Route("spot/{id}/love", name="spot_love")
     * @param LoveRepository $loveRepository
     * @param Request $request
     * @param Spot $spot
     * @param LoveManager $loveManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function love(LoveRepository $loveRepository,Request $request, Spot $spot, LoveManager $loveManager)
    {
        $formLove = $this->createForm(LoveType::class);
        $formLove->handleRequest($request);
        $spotId = $spot->getId();
        $user= $this->getUser();
        $love = $loveRepository->findLoveSpotByUSer($user,$spotId);
        if ($formLove->isSubmitted() && $formLove->isValid())
        {
             if($love)
             {
                 $this->addFlash("warning", "Vous avez déja liké ce spot!");
             }else{
                 $loveManager->save($formLove->getData(),$this->getUser(),$spot);
                 $this->addFlash("info", "Vous venez de liker ce spot!");
             }
        }
        return $this->redirectToRoute("accueil/spot",['id'=>$spot->getId()]);
    }

    /**
     * @Route("spot/{id}/tree", name="spot_tree")
     * @param TreeRepository $treeRepository
     * @param Request $request
     * @param Spot $spot
     * @param TreeManager $treeManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function tree(TreeRepository $treeRepository,Request $request, Spot $spot, TreeManager $treeManager)
    {
        $formTree = $this->createForm(TreeType::class);
        $formTree->handleRequest($request);
        $spotId = $spot->getId();
        $user = $this->getUser();
        $tree = $treeRepository->findTreeSpotByUSer($user, $spotId);
        if ($formTree->isSubmitted() && $formTree->isValid())
        {
            if($tree)
            {
                $this->addFlash("warning", "Vous avez déja Tree me ce spot!");
            }
            else{
                $treeManager->save($formTree->getData(),$this->getUser(),$spot);
                $this->addFlash("info", "Vous venez de Tree Me ce spot!");
            }
        }
        return $this->redirectToRoute("accueil/spot",['id'=>$spot->getId()]);
    }

    /**
     * @Route("spot/{id}/favoris", name="spot_favoris")
     * @Method({"POST"})
     * @param FavoriteRepository $favoriteRepository
     * @param Request $request
     * @param Spot $spot
     * @param FavoriteManager $favoriteManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function favoris(FavoriteRepository $favoriteRepository,Request $request, Spot $spot, FavoriteManager $favoriteManager)
    {
        $formFavoris = $this->createForm(FavoriteType::class);
        $formFavoris->handleRequest($request);
        $spotId = $spot->getId();
        $user = $this->getUser();
        $favorite = $favoriteRepository->findfavoriteSpotByUSer($user,$spotId);
        if($formFavoris->isSubmitted() && $formFavoris->isValid())
        {
            if($favorite)
            {
                $this->addFlash("warning", "Vous avez déja Fav me ce spot!");
            }
            else{
                $favoriteManager->save($formFavoris->getData(),$this->getUser(),$spot);
                $this->addFlash("info", "Vous venez de Fav Me ce spot!");
            }
        }
        return $this->redirectToRoute("accueil/spot",['id'=>$spot->getId()]);
    }

}

