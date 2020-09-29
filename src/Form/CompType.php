<?php

namespace App\Form;

use App\Entity\Comp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',
                TextType::class,
                array('label' => false)
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
                        'Bleu' => "success",
                        'Rouge' => "danger",
                        'Jaune' => "warning",
                        'Vert' => "primary",
                        'Violet' => "link",
                        'Bleu claire' => "info",
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
