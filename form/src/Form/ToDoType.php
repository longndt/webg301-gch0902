<?php

namespace App\Form;

use App\Entity\ToDo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToDoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,
                [
                    'attr' => [
                        'minlength' => 5,
                        'maxlength' => 15
                    ]
                ])
            ->add('content', TextType::class)
            ->add('date', DateType::class,
                [
                    'label' => 'Deadline',
                    'widget' => 'single_text'
                ])
            ->add('Add', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ToDo::class,
        ]);
    }
}
