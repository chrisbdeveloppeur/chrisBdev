<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/mon-espace", name="space")
     * @IsGranted("ROLE_USER")
     */
//    public function monEspace()
//    {
//        return $this->render('user/index.html.twig', [
//            'controller_name' => 'UserController',
//        ]);
//    }
}
