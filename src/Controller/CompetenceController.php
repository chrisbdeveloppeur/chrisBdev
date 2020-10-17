<?php

namespace App\Controller;

use App\Form\CompType;
use App\Repository\CompRepository;
use App\Repository\TechnoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CompetenceController extends AbstractController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("ajouter-competence", name="add_comp")
     * @IsGranted("ROLE_ADMIN")
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
            return $this->redirect('\#competences');
        }

        return $this->render('sections/competences/includes/add_comp.html.twig',[
            'comp_form' => $form->createView()
        ]);
    }

    /**
     * @Route("modifier-competence-{id}", name="edit_comp")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit_competence(Request $request, CompRepository $compRepository, $id, TechnoRepository $technoRepository)
    {
        $techno = $technoRepository->findAll();
        $competence = $compRepository->find($id);
        $form = $this->createForm(CompType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $competence = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competence);
            $entityManager->flush();
            return $this->redirect('\#competences');
        }
        return $this->render('sections/competences/includes/edit_comp.html.twig',[
            'comp_form' => $form->createView(),
            'techno' => $techno
        ]);
    }

    /**
     * @Route("supprimer-competence-{id}", name="del_comp")
     * @IsGranted("ROLE_ADMIN")
     */
    public function del_competence(CompRepository $compRepository, $id)
    {
        $competence = $compRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($competence);
        $entityManager->flush();
        return $this->redirectToRoute('home');

    }
}
