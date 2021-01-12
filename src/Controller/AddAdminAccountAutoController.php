<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AddAdminAccountAutoController extends AbstractController
{
    public function addAdminAuto(AdminRepository $adminRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        /*                         CREATION AUTO DU COMTE ADMIN                              */
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
            $admin->setNews(false);
            $admin->setEnable(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();
        }
        /***********************************************************************************/
    }
}
