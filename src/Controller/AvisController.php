<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvisController extends AbstractController
{
    /**
     * @Route("/add-avi", name="add_avi")
     */
    public function index(): Response
    {

        $message = 'Merci pour votre soutiens et d\'avoir pris le temps de donner un avi concernant chrisBdev. A très vite !';
        $this->addFlash('success',$message);
        return $this->redirectToRoute('home');
    }
}
