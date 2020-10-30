<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => false,
                'required' => false,
                'error_bubbling' => true,
            ])
            ->add('prenom', TextType::class, [
                'label' => false,
                'required' => false,
                'error_bubbling' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'error_bubbling' => true,
            ])
            ->add('objet', TextType::class, [
                'label' => false,
                'required' => false,
                'error_bubbling' => true,
            ])
            ->add('text', TextareaType::class, [
                'label' => false,
                'required' => false,
                'error_bubbling' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
