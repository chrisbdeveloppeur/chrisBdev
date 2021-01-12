<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AviType;
use App\Repository\AdminRepository;
use App\Repository\AttributRepository;
use App\Repository\AviRepository;
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
    public function home(CompRepository $compRepository, PresentationRepository $presentationRepository, ProjetRepository $projetRepository, TechnoRepository $technoRepository, AttributRepository $attributRepository, AviRepository $aviRepository)
    {
        $user = $this->getUser();
        $aviForm = $this->createForm(AviType::class);
        $competences = $compRepository->findAll();
        $presentations = $presentationRepository->findAll();
        $projets = $projetRepository->findAll();
        $techno = $technoRepository->findAll();
        $attribut = $attributRepository->findAll();
        $avis = $aviRepository->findAll();
        return $this->render('home/index.html.twig', [
            'competences' => $competences,
            'presentations' => $presentations,
            'projets' => $projets,
            'techno' => $techno,
            'attribut' => $attribut,
            'avi' => $avis,
            'avi_form' => $aviForm->createView(),
            'user' => $user,
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
