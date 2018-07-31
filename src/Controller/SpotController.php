<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Commentaire;
use App\Form\commentaireType;
use App\Form\commentType;
use App\Form\spotType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Spot;
use App\Entity\Comment;
use App\Entity\Tree;
use App\Entity\Like;

class SpotController extends Controller
{
    /**
     * @Route("accueil/je-spote", name="je-spote")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function makeSpot(Request $request, EntityManagerInterface $entityManager)
    {
        $spot = new Spot();
        $form = $this->createForm(spotType::class, $spot);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager =$this->getDoctrine()->getManager();
            $currentUser = $this->getUser();
            dump($currentUser);
            $spot->setUser($currentUser);
            $entityManager->persist($spot);
            $entityManager->flush();
            $this->addFlash('success', 'Votre spot est bien enregistré!');
              return $this->redirectToRoute('tous-les-spots');
        }
        return $this->render('spot/makeSpot.html.twig',[
            'spot' => $form->createView(),
        ]);
    }
    /**
     * @Route("accueil/je-cherche-un-spot", name="je-cherche-un-spot")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchSpot()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categories = $entityManager->getRepository(Category::class)->findAll();
        $spots = $entityManager->getRepository(Spot::class)->findAll();
        return $this->render('spot/searchSpot.html.twig',array(
            'spots' => $spots,
            'categories' => $categories
        ));
    }

    /**
     * @Route("accueil/tous-les-spots", name="tous-les-spots")
     * @param Spot $spot
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAllSpots(EntityManagerInterface $entityManager,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $spots = $em->getRepository(Spot::class)->findAll();
       // $nbComments = $em->getRepository(Comment::class)->countCommentsBySpot($spot->getId());
        return $this->render('spot/showAllSpots.html.twig',array(
            'spots' => $spots,
        //    'nbComments' => $nbComments,

        ));
    }

    /**
     * @Route("accueil/spot/{id}", name="spot")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showOneSpot(Request $request, EntityManagerInterface $entityManager,$id,Spot $spot)
    {
        $em = $this->getDoctrine()->getManager();
        $spot = $em->getRepository(Spot::class)->findOneBy(['id' => $id]);
        $nbComments = $em->getRepository(Comment::class)->countCommentsBySpot($spot->getId());
        $comment = new Comment();
        $form_comment = $this->createForm(commentType::class, $comment);
        $form_comment->handleRequest($request);
        if($form_comment->isSubmitted() && $form_comment->isValid())
        {
            $currentUser = $this->getUser();
            $comment->setSpot($spot);
            $comment->setUser($currentUser);
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success', 'Merci pour votre commentaire');
            dump($comment);
        }
        return $this->render('spot/showOneSpot.html.twig',array(
            'spot' => $spot,
            'comment' => $comment,
              'nbComments' => $nbComments,
            'form_comment' => $form_comment->createView(),
        ));
    }


    /**
     * @Route("accueil/map-search", name="map-search")
     * @param Request $request
     * @return JsonResponse
     */
    public function searchSpotMap(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $spots = $em->getRepository(Spot::class)->findAll();
        return new JsonResponse($spots);
    }

}

