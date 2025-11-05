<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email',
                    'autocomplete' => 'off',
                    'require' => true,
                ]
            ])
//            ->add('roles')
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'attr' => [
                    'placeholder' => 'Password',
                    'autocomplete' => 'off',
                    'require' => true,
                ]
            ])
            ->add('username', TextType::class, [
                'label' => 'Username',
                'attr' => [
                    'placeholder' => 'Username',
                    'autocomplete' => 'off',
                    'require' => true,
                ]
            ])
            ->add('firstName',TextType::class, [
                'label' => 'First Name',
                'attr' => [
                    'placeholder' => 'First Name',
                    'autocomplete' => 'off',
                    'require' => true,
                ]
            ])
            ->add('lastName',TextType::class, [
                'label' => 'Last Name',
                'attr' => [
                    'placeholder' => 'Last Name',
                    'autocomplete' => 'off',
                    'require' => true,
                ]
            ])
            ->add('bio', TextareaType::class)
//            ->add('avatar')
            ->add('isVerified', ChoiceType::class, [
                'label' => 'Is Verified',
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ],
                'attr' => [
                    'require' => true,
                ]
            ])
//            ->add('createdAt')
//            ->add('updatedAt')
//            ->add('lastLogin')
            ->add('submit', SubmitType::class, ['label' => 'Register']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
