<?php


namespace App\Notif;

use App\Entity\Message;
use Twig\Environment;

class NotifMessage
{

    /**
     * NotifMessageconstructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $renderer
     */
    private $mailer;
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }


    public function sendMessage(Message $message)
    {
        $mail = (new \Swift_Message('Message en provenance de vinnyvixi.com'))
            ->setFrom('chrisbdeveloppeur@gmail.com')
            /**
             * Ci dessous entrez l'adresse de l'utilisateur concerné : $message->getEmail()
             */
            ->setTo(['christian.boungou@gmail.com'])
            ->setBody($this->renderer->render('emails/message.html.twig',[
                'message' => $message,
            ]), 'text/html' );
        $this->mailer->send($mail);
    }

//    public function lostPassword(Admin $admin)
//    {
//        // Création de l'email de réinitialisation
//        $message = (new \Swift_Message('Réinitialisation de votre mot de passe'))
//            ->setFrom('admin@vinnyvixi.com')
//            ->setTo($admin->getEmail())
//            ->setBody($this->renderer->render('emails/reset_password.html.twig',[
//                'admin' => $admin
//            ]), 'text/html' );
//        $this->mailer->send($message);
//    }

}