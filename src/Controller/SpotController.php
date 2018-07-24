<?php

namespace App\Controller;

use App\Form\commentType;
use App\Form\spotType;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/je-spote", name="je-spote")
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
            $entityManager->persist($spot);
            $entityManager->flush();
            $this->addFlash('success', 'Votre spot est bien enregistré!');
            //  return $this->redirectToRoute('home');
        }
        return $this->render('spot/makeSpot.html.twig',[
            'spot' => $form->createView(),
        ]);
    }
    /**
     * @Route("/je-cherche-un-spot", name="je-cherche-un-spot")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchSpot()
    {
        return $this->render('spot/searchSpot.html.twig');
    }

    /**
     * @Route("/tous-les-spots", name="tous-les-spots")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAllSpots()
    {
        $em = $this->getDoctrine()->getManager();
        $spots = $em->getRepository(Spot::class)->findAll();
        return $this->render('spot/showAllSpots.html.twig',array(
            'spots' => $spots
        ));
    }

    /**
     * @Route("/spot/{id}", name="spot")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showOneSpot(Request $request, EntityManagerInterface $entityManager,$id,Spot $spot)
    {
        // $id = intval($spot->getId());
        $em = $this->getDoctrine()->getManager();
        // je récupère l'id du spot en cours dans $spot
        $spot = $em->getRepository(Spot::class)->findOneBy(['id' => $id]);
        dump($spot);
        // $em = $this->getDoctrine()->getManager();
        // $comments = $em->getRepository(Comment::class)->getCommentsBySpot($spot->getId());
        $comment = new Comment();
        $form = $this->createForm(commentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            // cette ligne enregistre le spot_id
            $comment->setSpot($spot);

            //$comment->setMessage($comment);
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success', 'Merci pour votre commentaire');
            dump($comment);
        }
        //  $comments = $em->getRepository(Spot::class)->findById($id);
        // $comments = $em->getRepository(Comment::class)->getCommentsBySpot($spot->getId());
        // $comments = $em->getRepository(Comment::class)->countCommentsBySpot($spot->getId());
        $comments = $em->getRepository(Comment::class)->recupCommentsBySpot($spot->getId());
        dump($comments);
        return $this->render('spot/showOneSpot.html.twig',array(
            'spot' => $spot,
            'comment' => $comment,
            'comments' => $comments,
            'form' => $form->createView()
        ));
    }

}

