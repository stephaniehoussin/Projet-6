<?php
namespace App\Services;


class MailerService
{

    private $mailer;
    private $twig;
    private const mail = 'stephaniehoussinparis@gmail.com';

    public function __construct( \Swift_Mailer $mailer,\Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }


    /**
     * @param array $data
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function contactSend(array $data)
    {
        $subject = 'Demande de contact';
        $from = $data['email'];
        $to = MailerService::mail;
        $body = $this->twig->render('mails/contact/contactSend.html.twig', [
            'data' => $data]);
        $this->send($subject, $from, $to, $body);

    }

    /**
     * @param string $subject
     * @param string $from
     * @param string $to
     * @param string $body
     */
    private function send(string $subject, string $from, string $to, string $body)
    {
        /** @var \Swift_Mime_SimpleMessage $mail */
        $mail = $this->mailer->createMessage();
        $mail->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body)
            ->setContentType('text/html');
        $this->mailer->send($mail);
    }


}