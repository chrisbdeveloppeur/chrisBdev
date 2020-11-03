<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\AdminRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin", name="admin_")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/gestion-utilisateur", name="gestion_utilisateur")
     */
    public function gestionUtilisateur(AdminRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render('admin/gestion_user.html.twig', [
            'user' => $users,
        ]);
    }

    /**
     * @Route("/modifier-user/{id}", name="user_edit")
     */
    public function editUser(Request $request, $id, AdminRepository $adminRepository)
    {
        $user = $adminRepository->find($id);
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
     * @Route("/desactiver-compte/{id}", name="desactiver_compte")
     */
    public function desactiverCompte(AdminRepository $userRepository, $id, Request $request)
    {
        $user = $userRepository->find($id);
        $user->setEnable(false);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

    /**
     * @Route("/activer-compte/{id}", name="activer_compte")
     */
    public function activerCompte(AdminRepository $userRepository, $id, Request $request)
    {
        $user = $userRepository->find($id);
        $user->setEnable(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }


    /**
     * @Route("/supprimer-compte/{user_id}", name="del_user")
     */
    public function delUser(AdminRepository $adminRepository, $user_id)
    {
        $user = $adminRepository->find($user_id);
        $userMail = $user->getEmail();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->remove($user);
        $entityManager->flush();

        $users = $userRepository->findAll();

        $this->addFlash('danger', 'Le compte ' . $userMail . 'à bien été supprimer');

        return $this->render('admin/gestion_user.html.twig', [
            'user' => $users
        ]);
    }


}
