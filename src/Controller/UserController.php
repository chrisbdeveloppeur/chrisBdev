<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/mon-espace", name="space")
     * @IsGranted("ROLE_USER")
     */
    public function monEspace(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'La modification de votre profiel à bien été prise en compte');

            return $this->redirect($request->server->get('HTTP_REFERER'));
        }


        return $this->render('User/edit_user.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
