<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Form\UserType;
use App\Repository\AdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user", name="user_")
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/mon-espace-perso", name="space")
     */
    public function monEspace(Request $request)
    {
        $user = $this->getUser();
        return $this->render('User/space_user.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/modifier-mon-profil", name="edit")
     */
    public function editUser(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'La modification de votre profil à bien été prise en compte');

            return $this->redirectToRoute('user_space');
        }


        return $this->render('User/edit_user.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }


    /**
     * @Route("/changer-mon-mdp", name="change_password")
     */
    public function changePswd(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();

        // Passage de l'utilisateur au formulaire pour pré-remplir les champs
        $changePasswordForm = $this->createForm(ChangePasswordType::class, $user);
        $changePasswordForm->handleRequest($request);

        // Vérification de validité
        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid())
        {

            $oldPassword = $request->request->get('change_password')['password'];

            if ($passwordEncoder->isPasswordValid($user, $oldPassword))
            {
                // Formulaire lié à une classe entité: getData() retourne l'entité
                $user = $changePasswordForm->getData();

                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $changePasswordForm->get('plainPassword')->getData()
                    )
                );
                // Mise à jour de l'entité en BDD

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();


                // Ajout d'un message flash
                $this->addFlash('success', 'Votre mot de passe a bien été modifié');
            }
            else
            {
                $this->addFlash('danger', 'L\'ancien mot de passe est incorrect');
            }



        }
        return $this->render('User/change_password.html.twig', [
            'user' => $user,
            'changePasswordForm' => $changePasswordForm->createView()
        ]);
    }
}
