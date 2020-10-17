<?php

namespace App\Controller;

use App\Form\AttributType;
use App\Repository\AttributRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AttributController extends AbstractController
{
    /**
     * @Route("/ajouter-attribut", name="add_attribut")
     */
    public function add_attribut(Request $request)
    {
        $attributform = $this->createForm(AttributType::class);
        $attributform->handleRequest($request);
        if ($attributform->isSubmitted() && $attributform->isValid()){
            $attribut = $attributform->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attribut);
            $entityManager->flush();

            $this->addFlash('success', 'L\'attribut "' . $attribut->getTitle() . '" a bien été ajoutée');

            return $this->redirect('\#projets');
        }
        return $this->render('sections/projets/includes/add_attribut.html.twig', [
            'attribut_form' => $attributform->createView(),
        ]);
    }

    /**
     * @Route("/editer-attribut-{id}", name="edit_attribut")
     */
    public function edit_attribut(Request $request, AttributRepository $attributRepository, $id)
    {
        $attribut = $attributRepository->find($id);
        $attributform = $this->createForm(AttributType::class, $attribut);
        $attributform->handleRequest($request);
        if ($attributform->isSubmitted() && $attributform->isValid()){
            $attribut = $attributform->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attribut);
            $entityManager->flush();

            $this->addFlash('success', 'L\'attribut "' . $attribut->getTitle() . '" a bien été modifiée');

            return $this->redirect('\#projets');
        }
        return $this->render('sections/projets/includes/edit_attribut.html.twig', [
            'attribut_form' => $attributform->createView(),
            'attribut' => $attribut,
        ]);
    }

    /**
     * @Route("/supprimer-attribut-{id}", name="del_attribut")
     */
    public function del_attribut(AttributRepository $attributRepository, $id, Request $request)
    {
        $attribut = $attributRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($attribut);
        $entityManager->flush();

        $this->addFlash('danger', 'L\'attribut "' . $attribut->getTitle() . '" a bien été supprimée');

        return $this->redirect($request->server->get('HTTP_REFERER'));
    }
}
