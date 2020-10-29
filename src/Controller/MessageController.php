<?php

namespace App\Controller;

use App\Form\MessageType;
use App\Notif\NotifMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, NotifMessage $notifMessage){
        $form = $this->createForm(MessageType::class);

        $user = $this->getUser();
//        dd($user);
        if ($user){
            $email = $user->getUsername();
            $nom = $user->getLastName();
            $prenom = $user->getName();
            $form->get('email')->setData($email);
            $form->get('nom')->setData($nom);
            $form->get('prenom')->setData($prenom);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $message = $form->getData();

            $this->addFlash('success', 'Ton message a bien été envoyé et il va être lu très soigneusement !');

            $notifMessage->sendMessage($message);

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/contact.html.twig', [
            'messageForm' => $form->createView(),
        ]);

    }
}
