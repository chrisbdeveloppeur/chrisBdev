<?php

namespace App\Controller;

use App\Form\TechnoType;
use App\Repository\TechnoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TechnoController extends AbstractController
{
    /**
     * @Route("/ajouter-techno", name="add_techno")
     */
    public function add_techno(Request $request, TechnoRepository $technoRepository)
    {
        $technoform = $this->createForm(TechnoType::class);
        $technoform->handleRequest($request);
        if ($technoform->isSubmitted() && $technoform->isValid()){
            $techno = $technoform->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($techno);
            $entityManager->flush();

            $this->addFlash('success', 'La technologie "' . $techno->getName() . '" a bien été ajoutée');

            return $this->redirect('\#presentation');
        }
        return $this->render('sections/projets/includes/add_techno.html.twig', [
            'techno_form' => $technoform->createView(),
        ]);
    }

    /**
     * @Route("/editer-techno-{id}", name="edit_techno")
     */
    public function edit_techno(Request $request, TechnoRepository $technoRepository, $id)
    {
        $techno = $technoRepository->find($id);
//        dd($techno);
        $technoform = $this->createForm(TechnoType::class, $techno);
        $technoform->handleRequest($request);
        if ($technoform->isSubmitted() && $technoform->isValid()){
            $techno = $technoform->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($techno);
            $entityManager->flush();

            $this->addFlash('success', 'La technologie "' . $techno->getName() . '" a bien été modifiée');

            return $this->redirect('\#projets');
        }
        return $this->render('sections/projets/includes/edit_techno.html.twig', [
            'techno_form' => $technoform->createView(),
            'techno' => $techno,
        ]);
    }

    /**
     * @Route("/retirer-techno-{id}", name="del_techno")
     */
    public function del_techno(TechnoRepository $technoRepository, $id)
    {
        $techno = $technoRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($techno);
        $entityManager->flush();

        $this->addFlash('danger', 'La technologie "' . $techno->getName() . '" a bien été supprimée');

        return $this->redirect('\#projets');
    }
}
