<?php

namespace App\Form;

use App\Entity\Projet;
use Doctrine\DBAL\Types\ObjectType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'required' => false
            ])

            ->add('dateReal', NumberType::class,[
                'label' => false,
                'required' => false,
                'invalid_message' => 'Veuillez selectionnez une Année valide.',
                'error_bubbling' => true,
            ])

            ->add('typedev', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => [
                    'Développement partiel' => 'Partielle',
                    'Développement complet' => 'Complète',
                    'Refonte graphique' => 'Refonte',
                    'Assistance' => 'Assistance',
                ]
            ])

            ->add('text', TextareaType::class, [
                'label' => false,
                'required' => false,
            ])

            ->add('link', TextType::class, [
                'label' => false,
                'required' => false,
            ])

            ->add('img', FileType::class,[
                'label' => false,
                'required' => false,
            ])

            ->add('img1', FileType::class,[
                'label' => false,
                'required' => false,
            ])

            ->add('img2', FileType::class,[
                'label' => false,
                'required' => false,
            ])

            ->add('img3', FileType::class,[
                'label' => false,
                'required' => false,
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
