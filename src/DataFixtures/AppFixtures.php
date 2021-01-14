<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Avi;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i=0; $i<50; $i++){
            $avis = new Avi();
            $avis->setDate($faker->dateTime);
            $avis->setValidated($faker->boolean);
            $avis->setUser($faker->userName);
            $avis->setCommentaire($faker->text);
            $avis->setNote($faker->numberBetween(1,5));
            $manager->persist($avis);
        }

        for ($i=0; $i<50; $i++){
            $user = new Admin();
            $user->setEmail('user'.$i.'@gmail.com');
            $user->setAgreeTerms(true);
            $user->setName($faker->name);
            $user->setLastName($faker->lastName);
            $user->setIsConfirmed(true);
            $password = $this->encoder->encodePassword($user, 'user'.$i);
            $user->setPassword($password);
            $user->setNews($faker->boolean);
            $user->setEnable(true);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
