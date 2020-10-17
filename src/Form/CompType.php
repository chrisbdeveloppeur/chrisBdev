<?php

namespace App\Form;

use App\Entity\Comp;
use App\Entity\Techno;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $techno = Techno::class;
        $builder
            ->add('name',
                EntityType::class, [
                    'label' => false,
                    'required' => false,
                    'class' => $techno,
                ]
            )


            ->add('value',
                NumberType::class,
                    array('label' => false,
                        'required' => false
                    )
            )
            ->add('color',
               ChoiceType::class,[
                    'choices' => [
                        'Bleu' => "blue",
                        'Bleu-ciel' => "skyblue",
                        'Jaune' => "yellow",
                        'Marron' => "brown",
                        'Orange' => "orange",
                        'Rouge' => "red",
                        'Violet' => "purple",
                        'Vert' => "green",
                        'Gris' => "grey",

                    ],
                    'label' => false,
                    'required' => false
                ]

            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comp::class,
        ]);
    }
}
