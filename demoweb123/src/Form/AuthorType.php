<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => 'Author Name',
                'required' => true,
                'attr' => [
                    'maxlength' => 30,
                    'minlength' => 5
                ]
            ])
            ->add('birthday', DateType::class,
            [
                'label' => 'Author DOB',
                'required' => true,
                'widget' => 'single_text'
            ])
            ->add('nationality', ChoiceType::class,
            [
                'label' => 'Author Nationality',
                'required' => true,
                //hiển thị list có sẵn cho người dùng chọn
                'choices' => [
                    'Vietnam' => 'Vietnam',
                    'Thailand' => 'Thailand',
                    'Singapore' => 'Singapore'
                ],
                'expanded' => true //radio button
                //default : expanded = false => drop-down list
            ])
            ->add('image')
            ->add('OK', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
