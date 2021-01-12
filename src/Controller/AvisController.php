<?php

namespace App\Controller;

use App\Entity\Avi;
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
        $avi = new Avi();
        $aviForm = $this->createForm(AviType::class);
        if ($this->getUser()){
            $user = $this->getUser();
            $aviForm->get('user')->setData($user->getUsername());
        }
        $aviForm->handleRequest($request);

        if ($aviForm->isSubmitted() && $aviForm->isValid()){
            $note = $aviForm->getData();
            $note->setUser($user);
            $em->persist($note);
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
