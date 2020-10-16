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
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $message = $form->getData();

            $this->addFlash('success', 'Votre message a bien été envoyer !');

            $notifMessage->sendMessage($message);

            return $this->redirectToRoute('contact');
        }

        return $this->render('sections/contact/contact.html.twig', [
            'messageForm' => $form->createView(),
        ]);

    }
}