<?php

namespace App\Controller;


use App\Entity\Opinion;
use App\Form\opinionType;
use Doctrine\ORM\EntityManagerInterface;
use const Grpc\OP_RECV_INITIAL_METADATA;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OpinionController extends Controller
{

    /**
     * @Route("accueil/add-opinion", name="add-opinion")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addOpinion(Request $request, EntityManagerInterface $entityManager)
    {
        $opinion = new Opinion();
        $form = $this->createForm(opinionType::class,$opinion);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager =$this->getDoctrine()->getManager();
            $currentUser = $this->getUser();
            $opinion->setUser($currentUser);
            $entityManager->persist($opinion);
            $entityManager->flush();
            $this->addFlash('success', 'votre opinion est bien enregistrée');
        }
        return $this->render('opinion/addOpinion.html.twig',[
            'opinion' => $form->createView(),
        ]);
    }

    /**
     * @Route("accueil/les-opinions", name="les-opinions")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAllOpinions(EntityManagerInterface $entityManager, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $opinions = $em->getRepository(Opinion::class)->findAll();
        return $this->render('opinion/showAllOpinions.html.twig',array(
            'opinions' => $opinions
        ));
    }
}
