<?php

namespace App\Controller;

use App\Form\AviType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvisController extends AbstractController
{
    /**
     * @Route("/add-avi", name="add_avi")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $aviUser = $user->getAvi();
        $aviForm = $this->createForm(AviType::class);
        $aviForm->handleRequest($request);

        if ($aviForm->isSubmitted() && $aviForm->isValid() && !$aviUser){
            $note = $aviForm->getData();
            $note->setAdmin($user);
            $em->persist($note);
            dd($note);
            $em->flush();
            $message = 'Merci pour votre soutiens et d\'avoir pris le temps de donner un avi concernant chrisBdev. A très vite !';
            $this->addFlash('success',$message);
            return $this->redirectToRoute('home');
        }

        return $this->render('sections/avis/add_avi.html.twig', [
            'avi_form' => $aviForm->createView(),
        ]);
    }
}
