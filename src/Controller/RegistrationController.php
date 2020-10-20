<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\LostPasswordType;
use App\Form\RegistrationFormType;
use App\Form\ResetPasswordType;
use App\Notif\NotifMessage;
use App\Repository\AdminRepository;
use App\Security\AdminLoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     *
     */
    public function register(NotifMessage $notifMessage,Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
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

            $this->addFlash('info', 'Ton compte a bien été créé ! Un mail de confirmation viens d\'être envoyer vers ta boite mail.');

            return $this->redirectToRoute('home');

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
            $this->addFlash('warning', 'Ton inscription a déjà été validée. Tu peux te connecter !');
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

        $this->addFlash('success', 'Ton compte à bien été validée ! Tu peux dès à présent t\'y connecter avec tes identifiants.');
        return $this->redirectToRoute('app_login');
    }



    /**
     * Demander un lien de réinitialisation du mot de passe
     * @Route("/lost-password", name="lost_password")
     *
     * @param Request         $request          Pour le formulaire
     * @param AdminRepository  $userRepository   Pour rechercher l'utilisateur
     * @param MailerInterface $mailer           Pour envoyer l'email de réinitialisation
     */
    public function lostPassword(Request $request, AdminRepository $adminRepository, NotifMessage $notifMessage)
    {

        $lostPasswordForm = $this->createForm(LostPasswordType::class);
        $lostPasswordForm->handleRequest($request);

        if ($lostPasswordForm->isSubmitted() && $lostPasswordForm->isValid()) {
            $designedUser = $lostPasswordForm->get('email')->getData();

            $user = $adminRepository->findOneBy(['email' => $designedUser]);

            if ($user === null) {
                $this->addFlash('danger', 'Cet adresse Email n\'est pas enregistrée');

            } else {


                $notifMessage->lostPassword($user);

                $this->addFlash('info', 'Un email de réinitialisation vient tout juste d\'être envoyé. Rendez-vous sur sa boite mail !');
                return $this->redirectToRoute('app_login');

            }
        }

        return $this->render('User/lost_password.html.twig', [
            'lost_password_form' => $lostPasswordForm->createView()
        ]);
    }




    /**
     * Réinitialiser le mot de passe
     * @Route("/reset-password/{id}/{token}", name="reset_password")
     *
     * @param Admin                          $user            L'utilisateur qui souhaite réinitialiser son mot de passe
     * @param                               $token           Le jeton à vérifier pour la réinitialisation
     * @param Request                       $request         Pour le formulaire de réinitialisation
     * @param EntityManagerInterface        $entityManager   Pour mettre à jour l'utilisateur
     * @param UserPasswordEncoderInterface $passwordEncoder Pour hasher le nouveau mot de passe
     */
    public function resetPassword(
        Admin $user,
        $token,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        // Le jeton ne correspond pas à celui de l'utilisateur
        if ($user->getSecurityToken() !== $token) {
            $this->addFlash('danger', 'Le jeton de sécurité est invalide.');
            return $this->redirectToRoute('app_login');
        }

        // Création du formulaire de réinitialisation du mot de passe
        $resetForm = $this->createForm(ResetPasswordType::class);
        $resetForm->handleRequest($request);

        if ($resetForm->isSubmitted() && $resetForm->isValid()) {
            $password = $resetForm->get('plainPassword')->getData();

            $oldPassword = $passwordEncoder->isPasswordValid($user, $password);

            if($oldPassword === false){
                $user->setPassword($passwordEncoder->encodePassword($user, $password));
                $user->renewToken();

                // Mise à jour de l'entité en BDD

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                // Ajout d'un message flash
                $this->addFlash('success', 'Ton mot de passe a bien été modifié.');
                return $this->redirectToRoute('app_login');
            }else{
                $this->addFlash('danger', 'Ton mot de passe doit être différent de l\'ancien !');
            }

        }

        return $this->render('User/reset_password.html.twig', [
            'reset_form' => $resetForm->createView()
        ]);
    }


}
