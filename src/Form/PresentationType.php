<?php

namespace App\Form;

use App\Entity\Presentation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class PresentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                    'label' => false,
                    'required' => false
            ])

            ->add('sub_title',TextType::class,[
                    'label' => false,
                    'required' => false
            ])

            ->add('text', TextareaType::class, [
                'label' => false,
                'required' => false,
            ])

            ->add('button_link', TextType::class,[
                'label' => false,
                'required' => false,
            ])

            ->add('img', FileType::class,[
                'label' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Presentation::class,
        ]);
    }
}
