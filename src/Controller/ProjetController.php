<?php

namespace App\Controller;

use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjetController extends AbstractController
{
    /**
     * @Route("/ajouter-projet", name="add_projet")
     * @IsGranted("ROLE_ADMIN")
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

            $this->addFlash('success', 'Le projet "' . $projet->getTitle() . '" à bien été modifié');

            return $this->redirect('\#projets');
        }

        return $this->render('sections/projets/includes/add_projet.html.twig',[
            'projet_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/modifier-projet-{id}", name="edit_projet")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit_projet(Request $request, ProjetRepository $projetRepository, $id)
    {
        $projet = $projetRepository->find($id);
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $projet = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            $this->addFlash('success', 'La présentation "' . $projet->getTitle() . '" à bien été modifié');

            return $this->render('sections/projets/includes/edit_projet.html.twig',[
                'projet' => $projet,
                'projet_form' => $form->createView()
            ]);

        }
        return $this->render('sections/projets/includes/edit_projet.html.twig',[
            'projet' => $projet,
            'projet_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimer-projet-{id}", name="del_projet")
     * @IsGranted("ROLE_ADMIN")
     */
    public function del_projet(ProjetRepository $projetRepository, $id)
    {
        $projet = $projetRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($projet);
        $entityManager->flush();
        return $this->redirect('\#projets');
    }

    /**
     * @Route("/supprimer-img-{id}", name="del_img")
     * @IsGranted("ROLE_ADMIN")
     */
    public function del_img(ProjetRepository $projetRepository, $id, Request $request)
    {
        $projet = $projetRepository->find($id);
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $projet->setImgName(null);
        $entityManager->flush();

        return $this->render('sections/projets/includes/edit_projet.html.twig',[
            'projet' => $projet,
            'projet_form' => $form->createView()
        ]);
    }
}
