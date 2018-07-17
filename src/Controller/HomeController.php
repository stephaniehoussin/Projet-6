<?php

namespace App\Controller;

use App\Form\connexionType;
use App\Form\inscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class HomeController extends Controller
{
    /**
     * @Route("/landing", name="landing")
     */
    public function landing()
    {
        return $this->render('landing/index.html.twig');
    }

    /**
     * @Route("/connexion", name="connexion")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connexion(Request $request)
    {
        $form = $this->createForm(connexionType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

        }
        return $this->render('landing/connexion.html.twig');
    }

    /**
     * @Route("inscription", name="inscription")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function inscription(Request $request, EntityManagerInterface $entityManager)
    {
        $user = new User();
        $form = $this->createForm(inscriptionType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Votre inscription est bien prise en compte, vous allez recevoir un email contenant un lien pour activer votre compte');
        }
        return $this->render('landing/inscription.html.twig',[
            'inscription' => $form->createView(),
        ]);
    }

    /**
     * @Route("/home", name="home")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home()
    {
        return $this->render('home/index.html.twig');
    }
}
