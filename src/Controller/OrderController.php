<?php

namespace App\Controller;

use App\Repository\PresentationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\RepositoryFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order-{order}/{id}", name="order")
     */
    public function orderUp(EntityManagerInterface $em, $id, PresentationRepository $presentationRepository, $order): Response
    {
        $presentation = $presentationRepository->find($id);
        if ($order == 'up'){
            $nextPosition = $presentation->getPosition() + 1 ;
            $positionForNextPresentation = $nextPosition - 1;
        }else{
            $nextPosition = $presentation->getPosition() - 1 ;
            $positionForNextPresentation = $nextPosition + 1;
        }

        $nextPresentation = $presentationRepository->findByPosition($nextPosition);
        if (!$nextPresentation){
            $presentation->setPosition($nextPosition);
            $em->persist($presentation);
            $em->flush();
        }else{
            $presentation->setPosition($nextPosition);
            $nextPresentation[0]->setPosition($positionForNextPresentation);
            $em->persist($nextPresentation[0]);
            $em->persist($presentation);
            $em->flush();
        }

        return $this->redirect('\#presentations');
    }

//    /**
//     * @Route("/order-down/{id}", name="order_down")
//     */
//    public function orderDown(EntityManagerInterface $em, $id, PresentationRepository $presentationRepository): Response
//    {
//        $presentation = $presentationRepository->find($id);
//        $prevPosition = $presentation->getPosition() - 1 ;
//        $prevPresentation = $presentationRepository->findByPosition($prevPosition);
//        $presentation->setPosition($prevPresentation[0]->getPosition());
//        $prevPresentation[0]->setPosition($presentation->getPosition());
//        $em->persist($presentation);
//        $em->flush();
//        $em->persist($prevPresentation[0]);
//        $em->flush();
//
//        return $this->redirect('\#presentations');
//    }


}
