<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Comment;
use App\Form\commentType;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/report_comment" , name="report_comment")
     */
    public function reportComment(Request $request, EntityManagerInterface $entityManager)
    {

      /*  $em = $this->getDoctrine()->getManager();
        $report = $em->getRepository(Comment::class)->commentIsReport();
        dump($report);
        return $report;*/

    }

}
