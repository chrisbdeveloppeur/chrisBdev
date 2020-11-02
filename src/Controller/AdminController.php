<?php

namespace App\Controller;

use App\Repository\AdminRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
