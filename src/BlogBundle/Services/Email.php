<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace BlogBundle\Services;

/**
 * Description of Email
 *
 * @author eric
 */
class Email {
    
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    private $twig;
    private $mailer_user;
    
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, $mailer_user)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->mailer_user = $mailer_user;
    }       
    public function sendEmail($data)
    {

        $message = new \Swift_Message();

        // Composition du message du mail
        $message
            ->setCharset('UTF-8')
            ->setSubject('Un mail de maximeraguideau.com')
            ->setBody($this->twig->render('mail.html.twig', array(
                'data' => $data,
            )))
            ->setContentType('text/html')
            ->setTo($this->mailer_user)
            ->setFrom(array($data['email'] => 'mon site'));
        // Envoi du message au visiteur
        $this->mailer->send($message);
    }
    
}
