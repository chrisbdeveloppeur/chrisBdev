<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Attribut;
use App\Entity\Avi;
use App\Entity\Comp;
use App\Entity\Presentation;
use App\Entity\Projet;
use App\Entity\Techno;
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


        for ($i=0; $i<4; $i++){
            $presentation = new Presentation();
            $presentation->setText($faker->realText('500'));
            $presentation->setTitle("Présentation N°".$i);
            $presentation->setSubTitle("Sous-titre présentation N°".$i);
            $manager->persist($presentation);
        }

        for ($i=0; $i<10; $i++){
            $competence = new Comp();
            $competence->setName("Compétence N°".$i);
            $competence->setValue($faker->randomElement([40,50,60,80,100]));
            $manager->persist($competence);
        }

        for ($i=0; $i<10; $i++){
            $projet = new Projet();
            $projet->setTitle("Projet N°".$i);
            $projet->setDateReal($faker->date());
            $projet->setTypedev($faker->randomElement(['Développement partiel','Développement complet','Refonte graphique','Assistance']));
            $projet->setText($faker->realText('500'));

            $randomUn = $faker->numberBetween(2,6);
            $randomDeux = $faker->numberBetween(2,10);

            for ($j=0; $j<$randomUn; $j++){
                $attribut = new Attribut();
                $attribut->setTitle("Attribut N°".$j);
                $attribut->setText($faker->realText('200'));
                $manager->persist($attribut);
                $projet->addAttribut($attribut);
            }
            for ($k=0; $k<$randomDeux; $k++){
                $techno = new Techno();
                $techno->setName("Tech-dev N°".$k);
                $techno->setHelp($faker->realText('50'));
                $manager->persist($techno);
                $projet->addTechno($techno);
            }
            $manager->persist($projet);
        }


        $manager->flush();
    }
}
