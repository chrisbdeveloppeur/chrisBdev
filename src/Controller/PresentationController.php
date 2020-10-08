<?php

namespace App\Controller;

use App\Form\PresentationType;
use App\Repository\PresentationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PresentationController extends AbstractController
{
    /**
     * @Route("/ajouter-presentation", name="add_presentation")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add_presentation(Request $request)
    {
        $form = $this->createForm(PresentationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $presentation = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($presentation);
            $entityManager->flush();

            $this->addFlash('success', 'La présentation "' . $presentation->getTitle() . '" à bien été modifié');

            return $this->redirectToRoute('home');
        }

        return $this->render('sections/presentation/includes/add_presentation.html.twig',[
            'presentation_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/modifier-presentation-{id}", name="edit_presentation")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit_presentation(Request $request, PresentationRepository $presentationRepository, $id)
    {
        $presentation = $presentationRepository->find($id);
        $form = $this->createForm(PresentationType::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $presentation = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($presentation);
            $entityManager->flush();

            $this->addFlash('success', 'La présentation "' . $presentation->getTitle() . '" à bien été modifié');

            return $this->render('sections/presentation/includes/edit_presentation.html.twig',[
                'presentation' => $presentation,
                'presentation_form' => $form->createView()
            ]);

        }
        return $this->render('sections/presentation/includes/edit_presentation.html.twig',[
            'presentation' => $presentation,
            'presentation_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimer-presentation-{id}", name="del_presentation")
     * @IsGranted("ROLE_ADMIN")
     */
    public function del_presentation(PresentationRepository $presentationRepository, $id)
    {
        $presentation = $presentationRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($presentation);
        $entityManager->flush();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/supprimer-img-{id}", name="del_img")
     * @IsGranted("ROLE_ADMIN")
     */
    public function del_img(PresentationRepository $presentationRepository, $id, Request $request)
    {
        $presentation = $presentationRepository->find($id);
        $form = $this->createForm(PresentationType::class, $presentation);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $presentation->setImgName(null);
        $entityManager->flush();

        return $this->render('sections/presentation/includes/edit_presentation.html.twig',[
            'presentation' => $presentation,
            'presentation_form' => $form->createView()
        ]);
    }
}
