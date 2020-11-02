<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use App\Repository\AttributRepository;
use App\Repository\CompRepository;
use App\Repository\PresentationRepository;
use App\Repository\ProjetRepository;
use App\Repository\TechnoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(UserPasswordEncoderInterface $passwordEncoder,CompRepository $compRepository, AdminRepository $adminRepository, PresentationRepository $presentationRepository, ProjetRepository $projetRepository, TechnoRepository $technoRepository, AttributRepository $attributRepository)
    {
        $evenAdmin = $adminRepository->findByMail('christian.boungou@gmail.com');
        if (!$evenAdmin){
            $admin = new Admin();
            $admin->setEmail('christian.boungou@gmail.com');
            $admin->setPassword(
                $passwordEncoder->encodePassword(
                    $admin,
                    '121090cb.K4gur0'
                )
            );
            $admin->setRoles(['ROLE_ADMIN']);
            $admin->setIsConfirmed(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();
        }


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


    /**
     * @Route("/mentions-legales", name="mentions_legales")
     */
    public function mentionsLegales()
    {
        return $this->render('RGPD/Mentions légales/page.html.twig', [
        ]);
    }

    /**
     * @Route("/politique-de-confidentialite", name="politique_de_confidentialite")
     */
    public function polotiqueDeConfidentialite()
    {
        return $this->render('RGPD/Politique de confidentialité/page.html.twig', [
        ]);
    }




}
