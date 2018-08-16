<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Spot;
use App\Form\ReportCommentType;
use App\Repository\CommentRepository;
use App\Services\CommentManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @Route("spot/{id}/comment/{comment_id}/report", name="comment-report")
     * @ParamConverter("comment", class="App:Comment", options={"id" = "comment_id"})
     * @Method({"POST"})
     * @param Spot $spot
     * @param Comment $comment
     * @param Request $request
     * @param CommentManager $commentManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function report(Spot $spot,Comment $comment,Request $request,CommentManager $commentManager,CommentRepository $commentRepository)
    {

        $commentsReport = $commentRepository->commentIsReport($comment->getId());
        dump($commentsReport);
        $formReportComment = $this->createForm(ReportCommentType::class);
        $formReportComment->handleRequest($request);
        if($formReportComment->isSubmitted() && $formReportComment->isValid())
        {
            $commentManager->report($formReportComment->getData(), $this->getUser());
            $this->addFlash("success", "Ce commentaire a été signalé!");
        }else{
            $this->addFlash("warning", "pas ok");

        }
        return $this->redirectToRoute('accueil/spot',['id'=>$spot->getId()]);


    }


}
