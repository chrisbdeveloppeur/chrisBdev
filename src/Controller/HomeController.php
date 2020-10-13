<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use App\Repository\CompRepository;
use App\Repository\PresentationRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(CompRepository $compRepository, AdminRepository $adminRepository, PresentationRepository $presentationRepository, ProjetRepository $projetRepository)
    {
        $evenAdmin = $adminRepository->findAll();

        if ($evenAdmin){

        }else{
            $admin = new Admin();
            $admin->setEmail('christian.boungou@gmail.com');
            $admin->setPassword('121090cb.K4gur0');
            $admin->setRoles(['ROLE_ADMIN']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();
        }



        $competences = $compRepository->findAll();
        $presentations = $presentationRepository->findAll();
        $projets = $projetRepository->findAll();
        return $this->render('home/index.html.twig', [
            'competences' => $competences,
            'presentations' => $presentations,
            'projets' => $projets,
        ]);
    }


}
