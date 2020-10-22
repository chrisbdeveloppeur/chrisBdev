<?php

namespace App\Controller;

use App\Form\ProjetType;
use App\Repository\AttributRepository;
use App\Repository\ProjetRepository;
use App\Repository\TechnoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/projet", name="projet_")
 * @IsGranted("ROLE_ADMIN")
 */
class ProjetController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
     */
    public function add_projet(Request $request)
    {
        $form = $this->createForm(ProjetType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $projet = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            $this->addFlash('success', 'Le projet "' . $projet->getTitle() . '" a été ajoutée');

            return $this->redirect('\#projets');
        }

        return $this->render('sections/projets/includes/add_projet.html.twig',[
            'projet_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
     */
    public function edit_projet(Request $request, ProjetRepository $projetRepository, $id, TechnoRepository $technoRepository, AttributRepository $attributRepository)
    {
        $techno = $technoRepository->findAll();
        $attribut = $attributRepository->findAll();
        $projet = $projetRepository->find($id);
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $projet = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            $this->addFlash('success', 'La présentation "' . $projet->getTitle() . '" a bien été modifié');

            return $this->redirect('\#projets');

        }
        return $this->render('sections/projets/includes/edit_projet.html.twig',[
            'attribut' => $attribut,
            'techno' => $techno,
            'projet' => $projet,
            'projet_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/supprimer", name="del")
     */
    public function del_projet(ProjetRepository $projetRepository, $id)
    {
        $projet = $projetRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($projet);
        $entityManager->flush();
        $this->addFlash('danger', 'La présentation "' . $projet->getTitle() . '" a été supprimée');
        return $this->redirect('\#projets');
    }

    /**
     * @Route("/{id}/supprimer-img", name="del_img")
     */
    public function del_img_projet(ProjetRepository $projetRepository, $id, Request $request)
    {
        $projet = $projetRepository->find($id);
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $projet->setImgProjetName(null);
        $entityManager->flush();

        return $this->render('sections/projets/includes/edit_projet.html.twig',[
            'projet' => $projet,
            'projet_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/ajouter-techno/{idtechno}", name="add_techno")
     */
    public function add_techno_to_project(ProjetRepository $projetRepository, $id, $idtechno, TechnoRepository $technoRepository)
    {
        $projet = $projetRepository->find($id);
        $techno = $technoRepository->find($idtechno);
        $entityManager = $this->getDoctrine()->getManager();
        $projet->addTechno($techno);
        $entityManager->flush();
        return $this->redirectToRoute('projet_edit',[
            'projet' => $projet,
            'id' => $projet->getId(),
        ]);
    }

    /**
     * @Route("/{id}/retirer-techno/{idtechno}", name="del_techno")
     */
    public function del_techno_to_project(ProjetRepository $projetRepository, $id, $idtechno, TechnoRepository $technoRepository)
    {
        $projet = $projetRepository->find($id);
        $techno = $technoRepository->find($idtechno);
        $entityManager = $this->getDoctrine()->getManager();
        $projet->removeTechno($techno);
        $entityManager->flush();
        return $this->redirectToRoute('projet_edit',[
            'projet' => $projet,
            'id' => $projet->getId(),
        ]);
    }




    /**
     * @Route("/{id}/ajouter-attribut/{idattribut}", name="add_attribut")
     */
    public function add_attribut_to_project(ProjetRepository $projetRepository, $id, $idattribut, AttributRepository $attributRepository)
    {
        $projet = $projetRepository->find($id);
        $attribut = $attributRepository->find($idattribut);
        $entityManager = $this->getDoctrine()->getManager();
        $projet->addAttribut($attribut);
        $entityManager->flush();
        return $this->redirectToRoute('projet_edit',[
            'projet' => $projet,
            'id' => $projet->getId(),
        ]);
    }

    /**
     * @Route("/{id}/retirer-attribut/{idattribut}", name="del_attribut")
     */
    public function del_attribut_to_project(ProjetRepository $projetRepository, $id, $idattribut, AttributRepository $attributRepository)
    {
        $projet = $projetRepository->find($id);
        $attribut = $attributRepository->find($idattribut);
        $entityManager = $this->getDoctrine()->getManager();
        $projet->removeAttribut($attribut);
        $entityManager->flush();
        return $this->redirectToRoute('projet_edit',[
            'projet' => $projet,
            'id' => $projet->getId(),
        ]);
    }

}
