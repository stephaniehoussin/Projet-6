<?php

namespace App\Controller;

use App\Entity\Spot;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\FavorisType;
use App\Form\LoveType;
use App\Form\ReportCommentType;
use App\Form\SpotFilterType;
use App\Form\SpotType;
use App\Form\TreeType;
use App\Repository\CommentRepository;
use App\Repository\SpotRepository;
use App\Services\CommentManager;
use App\Services\FavorisManager;
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
     * @param SpotRepository $spotRepository
     * @param $page
     * @return Response
     */
    public function searchSpot(PaginationService $paginationService,SpotRepository $spotRepository, $page, Request $request)
    {

        $formFilter = $this->createForm(SpotFilterType::class);
        $formFilter->handleRequest($request);

        if($formFilter->isSubmitted() && $formFilter->isValid())
        {
             $datas = $formFilter->getData();
            dump($datas);
             return $datas;

        }

        $spots = $spotRepository->findAllSpotsByDate($page);
        $pagination = $paginationService->paginationHome($page);
        return $this->render('home/searchSpot.html.twig', array(
            'spots' => $spots,
            'pagination' => $pagination,
            'formFilter' => $formFilter->createView(),
        ));
    }

    /**
     * @Route("spot/{id}", name="spot")
     * @param CommentRepository $commentRepository
     * @param PageDecoratorsService $pageDecoratorsService
     * @param CommentManager $commentManager
     * @param Request $request
     * @param Spot $spot
     * @return Response
     */
    public function showOneSpot(CommentRepository $commentRepository,PageDecoratorsService $pageDecoratorsService, CommentManager $commentManager, Request $request, Spot $spot)
    {
        $resultBySpot = $pageDecoratorsService->countDataBySpot($spot->getId());
        $formLove = $this->createForm(LoveType::class);
        $formTree = $this->createForm(TreeType::class);
        $formFavoris = $this->createForm(FavorisType::class);


        $formComment = $this->createForm(CommentType::class);
        $formComment->handleRequest($request);
        if ($formComment->isSubmitted() && $formComment->isValid())
        {
            $commentManager->save($formComment->getData(), $this->getUser(), $spot);

        }
        $formReport = $this->createForm(ReportCommentType::class);
        //$commentsReport = $commentRepository->commentIsReportByUser($spot->getId());
       // dump($commentsReport);



        return $this->render('home/showOneSpot.html.twig', array(
            'spot' => $spot,
            'formComment' => $formComment->createView(),
            'formLove' => $formLove->createView(),
            'formTree' => $formTree->createView(),
            'formFavoris' => $formFavoris->createView(),
            'formReport' => $formReport,
            'resultBySpot' => $resultBySpot,
          //  'commentsReport' => $commentsReport,

        ));
    }



    /**
     * @Route("spot/{id}/love", name="spot_love")
     * @Method({"POST"})
     * @param Request $request
     * @param Spot $spot
     * @param LoveManager $loveManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function love(Request $request, Spot $spot, LoveManager $loveManager)
    {
        $formLove = $this->createForm(LoveType::class);
        $formLove->handleRequest($request);
        if ($formLove->isSubmitted() && $formLove->isValid()) {
            $loveManager->save($formLove->getData(), $this->getUser(),$spot);
            $this->addFlash("success","ok");
        }else{
            $this->addFlash("warning", "pas ok");
        }
        return $this->redirectToRoute("accueil/spot",['id'=>$spot->getId()]);
    }

    /**
     * @Route("spot/{id}/tree", name="spot_tree")
     * @Method({"POST"})
     * @param Request $request
     * @param Spot $spot
     * @param TreeManager $treeManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function tree(Request $request, Spot $spot, TreeManager $treeManager)
    {
        $formTree = $this->createForm(TreeType::class);
        $formTree->handleRequest($request);
        if($formTree->isSubmitted() && $formTree->isValid())
        {
            $treeManager->save($formTree->getData(),$this->getUser(),$spot);
            $this->addFlash("success", "ok");
        }else{
            $this->addFlash("warning", "pas ok");
        }
        return $this->redirectToRoute("accueil/spot",['id'=>$spot->getId()]);
    }

    /**
     * @Route("spot/{id}/favoris", name="spot_favoris")
     * @Method({"POST"})
     * @param Request $request
     * @param Spot $spot
     * @param FavorisManager $favorisManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function favoris(Request $request, Spot $spot, FavorisManager $favorisManager)
    {
        $formFavoris = $this->createForm(FavorisType::class);
        $formFavoris->handleRequest($request);
        if($formFavoris->isSubmitted() && $formFavoris->isValid()){
            $favorisManager->save($formFavoris->getData(), $this->getUser(),$spot);
            $this->addFlash("success","ok");
        }else{
            $this->addFlash("warning", "pas ok");
        }
        return $this->redirectToRoute("accueil/spot",['id'=>$spot->getId()]);
    }

    /**
     * @Route("spot/{id}/report", name="comment_report")
     * @Method({"POST"})
     * @param Spot $spot
     * @param Comment $comment
     * @param CommentManager $commentManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function reportComment(Spot $spot,Comment $comment,CommentManager $commentManager,Request $request)
    {
        $formReport = $this->createForm(ReportCommentType::class);
        $formReport->handleRequest($request);
        if($formReport->isSubmitted() && $formReport->isValid()){
            $commentManager->save($formReport->getData(), $this->getUser(),$spot);
            $this->addFlash("success","ok");
        }else{
            $this->addFlash("warning", "pas ok");
        }
        return $this->redirectToRoute("accueil/spot",['id'=>$spot->getId()]);
    }

}

