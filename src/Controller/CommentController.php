<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Spot;
use App\form\ReportCommentType;
use App\Services\CommentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class CommentController extends Controller
{
    /**
     * @Route("/comment", name="comment")
     */
    public function index()
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    /**
     * @Route("spot/{id}/report", name="comment_report")
     * @Method({"POST"})
     * @param Request $request
     * @param Comment $comment
     * @param CommentManager $commentManager
     * @param Spot $spot
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function report(Spot $spot,Request $request,CommentManager $commentManager)
    {

        $formReportComment = $this->createForm(ReportCommentType::class);
        $formReportComment->handleRequest($request);
        if($formReportComment->isSubmitted() && $formReportComment->isValid())
        {
            $commentManager->report($formReportComment->getData(), $this->getUser());
            $this->addFlash("success", "ok");
        }else{
            $this->addFlash("warning", "pas ok");
        }

        return $this->redirectToRoute("accueil/spot",['id'=>$spot->getId()]);
    }


}
