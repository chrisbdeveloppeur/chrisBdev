<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\RegistrationFormType;
use App\Notif\NotifMessage;
use App\Security\AdminLoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     *
     */
    public function register(NotifMessage $notifMessage,Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AdminLoginAuthenticator $authenticator): Response
    {
        $user = new Admin();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);
            $user->setIsConfirmed(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $notifMessage->notifyRegistrationUser($user);

            $this->addFlash('info', 'Votre compte a bien été créé ! Un mail de confirmation vous à été envoyer');

            return $this->redirectToRoute('home');

            //return $guardHandler->authenticateUserAndHandleSuccess(
            //    $user,
            //    $request,
            //    $authenticator,
            //    'main' // firewall name in security.yaml
            //);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


    /**
     * Confirmation du compte après inscription (lien envoyé par email)
     * @Route("/user-confirmation/{id}/{token}", name="user_confirmation")
     *
     * @param Admin                 $user          L'utilisateur qui tente de confirmer son compte
     * @param                       $token        Le jeton à vérifier pour confirmer le compte
     * @param EntityManagerInterface $entityManager Pour mettre à jour l'utilisateur
     */

    public function confirmAccount(Admin $user, $token, EntityManagerInterface $entityManager)
    {
        // L'utilisateur a déjà confirmé son compte
        if ($user->getIsConfirmed()) {
            $this->addFlash('warning', 'Votre inscription est déjà confirmé, vous pouvez vous connecter.');
            return $this->redirectToRoute('app_login');
        }

        // Le jeton ne correspond pas à celui de l'utilisateur
        if ($user->getSecurityToken() !== $token) {
            $this->addFlash('danger', 'Le jeton de sécurité est invalide.');
            return $this->redirectToRoute('app_login');
        }

        // Le jeton est valide: mettre à jour le jeton et confirmer le compte
        $user->setIsConfirmed(true);
        $user->renewToken();

        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Vous pouvez maintenant vous connecter !');
        return $this->redirectToRoute('app_login');
    }

}
