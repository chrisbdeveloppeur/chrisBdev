<?php

namespace App\Controller;

use App\Form\AttributType;
use App\Repository\AttributRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/attribut", name="attribut_")
 * @IsGranted("ROLE_ADMIN")
 */
class AttributController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
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
     * @Route("/{id}/editer", name="edit")
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
     * @Route("/{id}/supprimer", name="del")
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
