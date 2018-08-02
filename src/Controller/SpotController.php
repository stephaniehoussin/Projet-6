<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\commentType;
use App\Form\SpotFilterType;
use App\Form\spotType;
use App\Repository\CommentRepository;
use App\Repository\SpotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Spot;
use App\Entity\Comment;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\Tree;
use App\Entity\Like;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SpotController extends Controller
{
    /**
     * @Route("accueil/je-spote", name="je-spote")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function makeSpot(Request $request)
    {
        $spot = new Spot();
        $form = $this->createForm(spotType::class, $spot);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $currentUser = $this->getUser();
            dump($currentUser);
            $spot->setUser($currentUser);
            $entityManager->persist($spot);
            $entityManager->flush();
            $this->addFlash('success', 'Votre spot est bien enregistré!');
            return $this->redirectToRoute('tous-les-spots', ['page' => 1]);
        }
        return $this->render('spot/makeSpot.html.twig', [
            'formSpot' => $form->createView(),
        ]);
    }

    /**
     * @Route("accueil/je-cherche-un-spot/", name="je-cherche-un-spot")
     * @param SpotRepository $spotRepository
     * @return Response
     */
    public function searchSpot(SpotRepository $spotRepository,Request $request)
    {
         $spots = $spotRepository->findAll();
        $form = $this->createForm(SpotFilterType::class);
        return $this->render('spot/searchSpot.html.twig', array(
            'spots' => $spots,
            'formFilter' => $form->createView()
        ));
    }

    public function ajaxFilter(Request $request)
    {
        $form = $this->createForm(SpotFilterType::class);
        $form->handleRequest($request);

        $form->getData();

    }

    /**
     * @Route("accueil/tous-les-spots/{page}", requirements={"page" = "\d+"} , name="tous-les-spots")
     * @param SpotRepository $spotRepository
     * @param Request $request
     * @param $page
     * @return Response
     */
    public function showAllSpots(SpotRepository $spotRepository, Request $request,$page)
    {
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
        return $this->render('spot/showAllSpots.html.twig', array(
            'spots' => $spots,
            'pagination' => $pagination
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
    public function showOneSpot(SpotRepository $spotRepository, CommentRepository $commentRepository, Request $request, EntityManagerInterface $entityManager, $id, Spot $spot)
    {

        $spot = $spotRepository->findOneBy(['id' => $id]);
        $nbComments = $commentRepository->countCommentsBySpot($spot->getId());
        $comment = new Comment();
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
     * @Route("accueil/map-search", name="map-search")
     * @param Request $request
     * @return Response
     */
    public function searchSpotMap(Request $request,SpotRepository $spotRepository)
    {
          $titles = array();
         $term = trim(strip_tags($request->get('term')));
         $spots = $spotRepository->findSpotByTitle($term);
         foreach($spots as $spot)
         {
             $titles[] = $spot->getTitle();
         }
         return new JsonResponse($titles);


    }

    /**
     * @Route("carte/", name="find")
     */
    public function test(SpotRepository $spotRepository,Request $request)
    {
        $spots = $spotRepository->findAll();
        $spot = new Spot();
        $form = $this->createForm(spotType::class, $spot);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $currentUser = $this->getUser();
            dump($currentUser);
            $spot->setUser($currentUser);
            $entityManager->persist($spot);
            $entityManager->flush();
            $this->addFlash('success', 'Votre spot est bien enregistré!');
            return $this->redirectToRoute('tous-les-spots');
        }

        return $this->render('landing/test.html.twig', array(
            'spots' => $spots,
            'formSpot' => $form->createView(),
        ));
    }
}

