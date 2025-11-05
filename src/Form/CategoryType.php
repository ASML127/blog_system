<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'autocomplete' => 'off',
                    'required' => true,
                ]
            ])
            ->add('description', TextareaType::class)
            ->add('color', ChoiceType::class, [
                'choices' => [
                    'Red' => 'Red',
                    'Green' => 'Green',
                    'Blue' => 'Blue',
                    'Yellow' => 'Yellow',
                    'White' => 'White',
                    'Gray' => 'Gray',
                    'Black' => 'Black',
                ],
                'label' => 'Color',
                'attr' => [
                    'autocomplete' => 'off',
                    'required' => true,
                ]
            ])
            ->add('isActive', ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false
                ],
                'label' => 'Active',
                'attr' => [
                    'autocomplete' => 'off',
                    'required' => true,
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'save',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
