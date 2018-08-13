<?php
namespace App\Services;

use App\Entity\Newsletter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class NewsletterService
{

    private $em;
    private $mailer;
    private $twig;

    public function __construct(EntityManagerInterface $em, \Swift_Mailer $mailer,\Twig_Environment $twig)
    {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }


    /**
     * @param Newsletter $newsletter
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function newsletterSend(Newsletter $newsletter)
    {
        $message = (new \Swift_Message('Inscription à la newsletter'))
            ->setFrom('stephaniehoussinparis@gmail.com')
            ->setTo($newsletter->getEmail())
            ->setBody($this->twig->render('newsletter/newsletterSubscribeEmail.html.twig', ['newsletter' => $newsletter]), 'text/html');
        $this->mailer->send($message);

    }


}