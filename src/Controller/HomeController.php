<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\MessageType;
use App\Form\TechnoType;
use App\Repository\AdminRepository;
use App\Repository\AttributRepository;
use App\Repository\CompRepository;
use App\Repository\PresentationRepository;
use App\Repository\ProjetRepository;
use App\Repository\TechnoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(CompRepository $compRepository, AdminRepository $adminRepository, PresentationRepository $presentationRepository, ProjetRepository $projetRepository, TechnoRepository $technoRepository, AttributRepository $attributRepository)
    {
//        $evenAdmin = $adminRepository->findAll();
//
//        if ($evenAdmin){
//
//        }else{
//            $admin = new Admin();
//            $admin->setEmail('christian.boungou@gmail.com');
//            $admin->setPassword('121090cb.K4gur0');
//            $admin->setRoles(['ROLE_ADMIN']);
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($admin);
//            $entityManager->flush();
//        }


        $competences = $compRepository->findAll();
        $presentations = $presentationRepository->findAll();
        $projets = $projetRepository->findAll();
        $techno = $technoRepository->findAll();
        $attribut = $attributRepository->findAll();
        return $this->render('home/index.html.twig', [
            'competences' => $competences,
            'presentations' => $presentations,
            'projets' => $projets,
            'techno' => $techno,
            'attribut' => $attribut,
        ]);
    }




}
