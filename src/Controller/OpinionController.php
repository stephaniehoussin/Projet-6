<?php

namespace App\Controller;


use App\Entity\Opinion;
use App\Form\opinionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OpinionController extends Controller
{
    /**
     * @Route("/opinion", name="opinion")
     */
    public function index()
    {
        return $this->render('opinion/index.html.twig', [
            'controller_name' => 'OpinionController',
        ]);
    }

    /**
     * @Route("/add_opinion", name="add_opinion")
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
            $entityManager->persist($opinion);
            $entityManager->flush();
            $this->addFlash('success', 'votre opinion est bien enregistrée');
        }
        return $this->render('opinion/addOpinion.html.twig',[
            'opinion' => $form->createView(),
        ]);
    }
}
