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
     * @Route("comment/{id}/report", name="comment-report")
     * @ParamConverter("comment", class="App:Comment", options={"id" = "id"})
     * @Method({"POST"})
     * @param $id
     * @param CommentManager $commentManager
     * @param CommentRepository $commentRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function reportComment($id,CommentManager $commentManager,CommentRepository $commentRepository)
    {
            $comment = $commentRepository->find($id);
             $comment->setReport(1);
             $commentManager->save($comment);
            $spot = $comment->getSpot();
            $idSpot = $spot->getId();
        $this->addFlash("success","Vous venez de signaler un commentaire!");
        return $this->redirectToRoute('accueil/spot',[
            'id'=>$idSpot]);

    }

    /**
     * @Route("valider-commentaires-signales/{id}", name="valider-commentaires")
     * @param CommentManager $commentManager
     * @param $id
     * @param CommentRepository $commentRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function validateReportComment(CommentManager $commentManager,$id,CommentRepository $commentRepository)
    {
        $comment = $commentRepository->find($id);
        $comment->setReport(0);
        $commentManager->save($comment);
        $this->addFlash('success', 'Le commentaire n\'est plus signalé');
        return $this->redirectToRoute('mon-compte/commentaires-signales');
    }

    /**
     * @Route("supprimer-commentaires-signales/{id}", name="supprimer-commentaires")
     * @param $id
     * @param CommentRepository $commentRepository
     * @param CommentManager $commentManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteReportComment($id,CommentRepository $commentRepository, CommentManager $commentManager)
    {
        $comment = $commentRepository->find($id);
        $commentManager->suppressComment($comment);
        $this->addFlash('success', 'Le commentaire a été supprimé avec succès');
        return $this->redirectToRoute('mon-compte/commentaires-signales');

    }


}
