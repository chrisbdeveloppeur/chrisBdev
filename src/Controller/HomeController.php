<?php

namespace App\Controller;

use App\Entity\Comp;
use App\Form\CompType;
use App\Repository\CompRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(CompRepository $compRepository)
    {
        $competences = $compRepository->findAll();
        return $this->render('home/index.html.twig', [
            'competences' => $competences,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("ajouter-competence", name="add_comp")
     */
    public function add_competence(Request $request)
    {
        $form = $this->createForm(CompType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $competence = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competence);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('sections/competences/add_comp.html.twig',[
            'comp_form' => $form->createView()
        ]);
    }


}
