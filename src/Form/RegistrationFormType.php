<?php

namespace App\Form;

use App\Entity\Admin;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('captchaCode', CaptchaType::class, array(
//                'captchaConfig' => 'ExampleCaptcha',
//                'label' => false,
//                'error_bubbling' => true,
//            ))
            ->add('email', EmailType::class,[
                'label' => false,
                'error_bubbling' => true,
                'constraints' => [
                        new NotBlank(['message' => 'Veuillez remplir ce champ.']),
                        new Email(['message' => 'Veuillez indiquer une adresse mail valide. Exemple : mon_adresse_mail@gmail.com']),
                    ],
            ])
            ->add('pseudo', TextType::class,[
                'label' => false,
                'required' => false,
                'error_bubbling' => true,
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe indiqués ne sont pas identiques',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'error_bubbling' => true,
                'first_options'  => ['label' => false],
                'second_options' => ['label' => false, 'required' => true,],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('news', CheckboxType::class,[
                'label' => false,
                'error_bubbling' => true,
                'required' => false,
            ])

            ->add('agreeTerms', CheckboxType::class,[
                'label' => false,
                'error_bubbling' => true,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez accepter les conditions générales',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}
