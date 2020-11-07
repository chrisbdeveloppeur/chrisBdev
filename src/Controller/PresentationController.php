<?php

namespace App\Controller;

use App\Form\PresentationType;
use App\Repository\PresentationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/presentation", name="presentation_")
 * @IsGranted("ROLE_ADMIN", message="Vous n'êtes pas éligible à cette page !")
 */
class PresentationController extends AbstractController
{
    /**
     * @Route("/ajouter", name="add")
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

            $this->addFlash('success', 'La présentation "' . $presentation->getTitle() . '" a été ajoutée');

            return $this->redirect('\#presentation');
        }

        return $this->render('sections/presentation/includes/add_presentation.html.twig',[
            'presentation_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit")
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

            $this->addFlash('success', 'La présentation "' . $presentation->getTitle() . '" a bien été modifié');

            return $this->redirect('\#presentation');
//            return $this->json(['code' => 200, 'message' => 'ça marche']);
        }
        return $this->render('sections/presentation/includes/edit_presentation.html.twig',[
            'presentation' => $presentation,
            'presentation_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/supprimer", name="del")
     */
    public function del_presentation(PresentationRepository $presentationRepository, $id)
    {
        $presentation = $presentationRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($presentation);
        $entityManager->flush();

        $this->addFlash('danger', 'La présentation "' . $presentation->getTitle() . '" a été supprimée');

        return $this->redirect('\#presentation');
    }

    /**
     * @Route("/{id}/supprimer-img", name="img_del")
     */
    public function del_img_presentation(PresentationRepository $presentationRepository, $id, Request $request)
    {
        $presentation = $presentationRepository->find($id);
        $form = $this->createForm(PresentationType::class, $presentation);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $presentation->setImgPresentationName(null);
        $entityManager->flush();

        return $this->render('sections/presentation/includes/edit_presentation.html.twig',[
            'presentation' => $presentation,
            'presentation_form' => $form->createView()
        ]);
    }
}
