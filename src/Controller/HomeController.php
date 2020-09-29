<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Comp;
use App\Form\CompType;
use App\Repository\AdminRepository;
use App\Repository\CompRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(CompRepository $compRepository, AdminRepository $adminRepository)
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
        return $this->render('home/index.html.twig', [
            'competences' => $competences,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("ajouter-competence", name="add_comp")
     */
    public function add_competence(Request $request)
    {
        $form = $this->createForm(CompType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $competence = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competence);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('sections/competences/add_comp.html.twig',[
            'comp_form' => $form->createView()
        ]);
    }

    /**
     * @Route("edit-competence-{id}", name="edit_comp")
     */
    public function edit_competence(Request $request, CompRepository $compRepository, $id)
    {
        $competence = $compRepository->find($id);
        $form = $this->createForm(CompType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $competence = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competence);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('sections/competences/edit_comp.html.twig',[
            'comp_form' => $form->createView()
        ]);
    }

    /**
     * @Route("del-competence-{id}", name="del_comp")
     */
    public function del_competence(CompRepository $compRepository, $id)
    {
        $competence = $compRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($competence);
        $entityManager->flush();
        return $this->redirectToRoute('home');

    }


}
