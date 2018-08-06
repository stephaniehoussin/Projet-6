<?php

namespace App\Controller;


use App\Entity\Opinion;
use App\Form\opinionType;
use App\Repository\OpinionRepository;
use App\Services\SpotManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OpinionController extends Controller
{

    /**
     * @Route("accueil/add-opinion", name="add-opinion")
     * @param Request $request
     * @param SpotManager $spotManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addOpinion(Request $request, SpotManager $spotManager)
    {
        $opinion = new Opinion();
        $form = $this->createForm(opinionType::class,$opinion);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $currentUser = $this->getUser();
            $opinion->setUser($currentUser);
            $spotManager->persistOpinion($opinion);
            $this->addFlash('success', 'votre opinion est bien enregistrée');
        }
        return $this->render('opinion/addOpinion.html.twig',[
            'opinion' => $form->createView(),
        ]);
    }

    /**
     * @Route("accueil/les-opinions", name="les-opinions")
     * @param OpinionRepository $opinionRepository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAllOpinions(OpinionRepository $opinionRepository, Request $request)
    {
        $opinions = $opinionRepository->findAll();
        return $this->render('opinion/showAllOpinions.html.twig',array(
            'opinions' => $opinions
        ));
    }
}
