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
     * @Route("/add-avis", name="add_avis")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $aviForm = $this->createForm(AviType::class);

        $user = $this->getUser();
        if ($user){
            $aviForm->get('user')->setData($this->getUser()->getUsername());
        }
        $aviForm->handleRequest($request);
        if ($aviForm->isSubmitted() && $aviForm->isValid()){
            $note = $aviForm->getData();
            $em->persist($note);
            $em->flush();
            $message = 'Merci pour votre soutiens et d\'avoir pris le temps de donner un avi concernant chrisBdev';
            $this->addFlash('success',$message);
            return $this->redirectToRoute('home');
        }

        return $this->render('sections/avis/add_avi.html.twig', [
            'avi_form' => $aviForm->createView(),
        ]);
    }
}
