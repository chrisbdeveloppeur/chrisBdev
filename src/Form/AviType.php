<?php

namespace App\Form;

use App\Entity\Avi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AviType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note', ChoiceType::class,[
                    'label' => false,
                    'multiple' => false,
                    'expanded' => true,
                    'choice_label' => false,
                    'choices' => [
                        '1' => 1,
                        '2' => 2,
                        '3' => 3,
                        '4' => 4,
                        '5' => 5,
                    ]
                ])
            ->add('commentaire', TextareaType::class,[
                'required' => false,
            ])
            ->add('user', TextType::class,[
                'required' => true,
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Avi::class,
        ]);
    }
}
