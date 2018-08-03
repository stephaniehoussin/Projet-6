<?php

namespace App\Controller;

use App\Form\commentType;
use App\Form\SpotFilterType;
use App\Form\spotType;
use App\Repository\CommentRepository;
use App\Repository\SpotRepository;
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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function makeSpot(SpotManager $spotManager,Request $request, EntityManagerInterface $entityManager)
    {
        $spot = $spotManager->initSpot();
        $form = $this->createForm(spotType::class, $spot);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $spotManager->makeSpotManager($spot);
            $currentUser = $this->getUser();
            if($currentUser->hasRole('ROLE_MODERATEUR'))
            {
                $spot->setStatus(2);
            }
            $spot->setUser($currentUser);
            $entityManager->persist($spot);
            $entityManager->flush();
            $this->addFlash('success', 'Votre spot est bien enregistré!');
            return $this->redirectToRoute('je-cherche-un-spot', ['page' => 1]);
        }
        return $this->render('spot/makeSpot.html.twig', [
            'formSpot' => $form->createView(),
        ]);
    }

    /**
     * @Route("accueil/je-cherche-un-spot/{page}", requirements={"page" = "\d+"} , name="je-cherche-un-spot")
     * @param SpotRepository $spotRepository
     * @param Request $request
     * @param $page
     * @return Response
     */
    public function searchSpot(SpotRepository $spotRepository, Request $request,$page)
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
     * @param SpotRepository $spotRepository
     * @param CommentRepository $commentRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @param Spot $spot
     * @return Response
     */
    public function showOneSpot(SpotManager $spotManager,SpotRepository $spotRepository, CommentRepository $commentRepository, Request $request, EntityManagerInterface $entityManager, $id, Spot $spot)
    {

        $spot = $spotRepository->findOneBy(['id' => $id]);
        $nbComments = $commentRepository->countCommentsBySpot($spot->getId());
        $comment = $spotManager->initComment();
        $form = $this->createForm(commentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $currentUser = $this->getUser();
            $comment->setSpot($spot);
            $comment->setUser($currentUser);
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success', 'Merci pour votre commentaire');
            dump($comment);
        }
        return $this->render('spot/showOneSpot.html.twig', array(
            'spot' => $spot,
            'comment' => $comment,
            'nbComments' => $nbComments,
            'formComment' => $form->createView(),
        ));
    }

    /**
     * @Route("/recherche", name="recherche")
     * @param SpotRepository $spotRepository
     * @return JsonResponse
     */
    public function recupSpotForJs(SpotRepository $spotRepository)
    {
        $spots = $spotRepository->findAll();
        return new JsonResponse($spots);
    }

}

