<?php

namespace App\Controller;

use App\Repository\AdminRepository;
use App\Repository\AttributRepository;
use App\Repository\AviRepository;
use App\Repository\CompRepository;
use App\Repository\PresentationRepository;
use App\Repository\ProjetRepository;
use App\Repository\TechnoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(CompRepository $compRepository, PresentationRepository $presentationRepository, ProjetRepository $projetRepository, TechnoRepository $technoRepository, AttributRepository $attributRepository, AviRepository $aviRepository, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $competences = $compRepository->findAll();
        $presentations = $presentationRepository->orderByPosition();
        $presentationLenght = count($presentations);
        for ($i=0; $i<$presentationLenght; $i++){
            $position = $i+1;
            $currentPosition = $presentations[$i]->getPosition();
            if ($currentPosition == 0){
                $presentations[$i]->setPosition($position);
                $em->persist($presentations[$i]);
                $em->flush();
            }

        }
//        die();
        $projets = $projetRepository->findAll();
        $techno = $technoRepository->findAll();
        $attribut = $attributRepository->findAll();
        $avis = $aviRepository->findAllByNote();

        return $this->render('home/index.html.twig', [
            'competences' => $competences,
            'presentations' => $presentations,
            'projets' => $projets,
            'techno' => $techno,
            'attribut' => $attribut,
            'avis' => $avis,
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
