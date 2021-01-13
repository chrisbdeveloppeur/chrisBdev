<?php

namespace App\Controller;

use App\Entity\Avi;
use App\Form\AviType;
use App\Notif\NotifMessage;
use App\Repository\AviRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvisController extends AbstractController
{
    /**
     * @Route("/add-avis", name="add_avis")
     */
    public function index(Request $request, EntityManagerInterface $em, NotifMessage $notifMessage): Response
    {
        $aviForm = $this->createForm(AviType::class);

//        dd($aviForm->get('note'));
        $user = $this->getUser();
//        $aviForm->get('date')->setData($date);
        if ($user){
            if ($user->getPseudo()){
                $aviForm->get('user')->setData($this->getUser()->getPseudo());
            }elseif ($user->getName() && $user->getLastName()){
                $userName = $user->getName() . ' ' . $user->getLastName();
                $aviForm->get('user')->setData($userName);
            }else{
                $aviForm->get('user')->setData($this->getUser()->getUsername());
            }
        }
        $aviForm->handleRequest($request);
        if ($aviForm->isSubmitted() && $aviForm->isValid()){
            $avis = $aviForm->getData();
            $em->persist($avis);
            $em->flush();
            $notifMessage->sendAvis($avis);
            $message = 'Merci pour votre soutiens et d\'avoir pris le temps de donner un avi concernant chrisBdev';
            $this->addFlash('success',$message);
            return $this->redirect('\#avis');
        }

        return $this->render('sections/avis/add_avi.html.twig', [
            'avi_form' => $aviForm->createView(),
        ]);
    }

    /**
     * @Route("/confirm-avis/{id}", name="confirm_avis")
     */
    public function confirmAvis($id, AviRepository $aviRepository, EntityManagerInterface $em){
        $avis = $aviRepository->find($id);
        $avis->setValidated(true);
        $em->persist($avis);
        $em->flush();
        $message = 'Vous venez d\'approuver l\'avis client de '. $avis->getUser();
        $this->addFlash('success',$message);
        return $this->redirect('\#avis');
    }


    /**
     * @Route("/on-off-avis/{id}", name="on_off_avis")
     */
    public function onOffAvis($id, AviRepository $aviRepository, EntityManagerInterface $em){
        $avis = $aviRepository->find($id);
        if ($avis->getValidated()==true){
            $avis->setValidated(false);
            $message = 'Vous venez de retirer la visibilité de l\'avis client de '. $avis->getUser();
        }else{
            $avis->setValidated(true);
            $message = 'Vous venez de rendre visible l\'avis client de '. $avis->getUser();
        }

        $em->persist($avis);
        $em->flush();
        $this->addFlash('success',$message);
        return $this->redirect('\#avis');
    }


    /**
     * @Route("/delete-avis/{id}", name="delete_avis")
     */
    public function deleteAvis($id, AviRepository $aviRepository, EntityManagerInterface $em){
        $avis = $aviRepository->find($id);
        $avis->setValidated(true);
        $em->persist($avis);
        $em->flush();
        $message = 'Vous venez d\'approuver l\'avis client de '. $avis->getUser();
        $this->addFlash('success',$message);
        return $this->redirect('\#avis');
    }



}
