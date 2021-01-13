<?php


namespace App\Notif;

use App\Entity\Admin;
use App\Entity\Avi;
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
        $mail = (new \Swift_Message('Chris B Dev - Un utilisateur vient de vous envoyer un message'))
            ->setFrom('admin@chrisbdev.com')
            /**
             * Ci dessous entrez l'adresse de l'utilisateur concerné : $message->getEmail()
             */
            ->setTo(['chrisbdeveloppeur@gmail.com'])
            ->setBody($this->renderer->render('emails/message.html.twig',[
                'message' => $message,
            ]), 'text/html' );
        $this->mailer->send($mail);
    }

    public function notifyRegistrationUser(Admin $user)
    {
        $message = (new \Swift_Message('Chris B Dev - Mail de confirmation pour la création de compte'))
            ->setFrom('admin@chrisbdev.com')
//            ->setTo($user->getEmail())
            ->setTo('kenshin91cb@gmail.com')
            ->setBody($this->renderer->render('emails/confirmation_user.html.twig',[
                'user' => $user,
            ]), 'text/html' );
        $this->mailer->send($message);
    }

    public function notifyRegistrationUserToAdmin(Admin $user)
    {
        $messageToAdmin = (new \Swift_Message('Chris B Dev - Un utilisateur vient de créer son profile'))
            ->setFrom('admin@chrisbdev.com')
            ->setTo('chrisbdeveloppeur@gmail.com')
            ->setBody($this->renderer->render('emails/confirmation_user_to_admin.html.twig',[
                'user' => $user,
            ]), 'text/html' );
        $this->mailer->send($messageToAdmin);
    }

    public function lostPassword(Admin $user)
    {
//         Création de l'email de réinitialisation
        $message = (new \Swift_Message('chris B dev - Réinitialisation de votre mot de passe'))
            ->setFrom('admin@chrisbdev.com')
            ->setTo($user->getEmail())
//                ->setTo('kenshin91cb@gmail.com')
            ->setBody($this->renderer->render('emails/reset_password.html.twig',[
                'user' => $user,
            ]), 'text/html' );
        $this->mailer->send($message);
    }


    public function sendAvis(Avi $avis)
    {
        $message = (new \Swift_Message('chris B dev - Avis client'))
            ->setFrom('admin@chrisbdev.com')
            ->setTo('chrisbdeveloppeur@gmail.com')
//                ->setTo('kenshin91cb@gmail.com')
            ->setBody($this->renderer->render('emails/confirmation_avis.html.twig',[
                'avis' => $avis,
            ]), 'text/html' );
        $this->mailer->send($message);
    }

}