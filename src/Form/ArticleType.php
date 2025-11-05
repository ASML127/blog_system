<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr' => [
                    'autocomplete' => 'off',
                    'required' => true,
                ]
            ])
//            ->add('slug')
            ->add('content', TextareaType::class, [
                'label' => 'Content',
            ])
//            ->add('excerpt')
//            ->add('feauturedImage')
            ->add('status', ChoiceType::class, [
                'label' => 'Status',
                'choices' => [
                    'publish' => 'Publish',
                    'draft' => 'Draft',
                ],
                'attr' => [
                    'autocomplete' => 'off',
                    'required' => true,
                ]
            ])
            ->add('isFeatured', ChoiceType::class, [
                'label' => 'Featured',
                'choices' => [
                    'yes' => 'Yes',
                    'no' => 'No',
                ]
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
