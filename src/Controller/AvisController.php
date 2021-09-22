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

/**
 * @Route("/avis", name="avis_")
 */
class AvisController extends AbstractController
{

    /**
     * @Route("/all", name="all")
     */
    public function allAvis(AviRepository $aviRepository){

        $user = $this->getUser();

        if ($user && (in_array("ROLE_ADMIN",$user->getRoles()) ) ){
            $avis = $aviRepository->findAllByDate();
            $avisValidated = $aviRepository->findAllValidated();
            return $this->render('sections/avis/all_avis.html.twig', [
                'avis' => $avis,
                'avisValidated' => $avisValidated,
            ]);
        }else{
            $avis = $aviRepository->findAllValidated();
            return $this->render('sections/avis/all_avis.html.twig', [
                'avis' => $avis,
            ]);
        }

    }


    /**
     * @Route("/add", name="add", methods={"GET","POST"})
     */
    public function index(Request $request, EntityManagerInterface $em, NotifMessage $notifMessage): Response
    {
        $aviForm = $this->createForm(AviType::class);

        $user = $this->getUser();

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
     * @Route("/confirm/{id}", name="confirm")
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
     * @Route("/on-off/{id}", name="on_off")
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
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAvis($id, AviRepository $aviRepository, EntityManagerInterface $em){
        $avis = $aviRepository->find($id);
        $em->remove($avis);
        $em->flush();
        $message = 'Vous venez de supprimer l\'avis client de '. $avis->getUser();
        $this->addFlash('success',$message);
        return $this->redirect('\#avis');
    }



}
