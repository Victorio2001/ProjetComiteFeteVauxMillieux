<?php
// src/Form/ManifestationType.php

namespace App\Form;

use App\Entity\Manifestation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ManifestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreManifestation', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                    new NotNull(),
                ],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Titre de la Manifestation']
            ])
            ->add('descriptionManifestation', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                    new NotNull(),
                ],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Description de la Manifestation']
            ])
            ->add('dateDebutManifestation', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateFinManifestation', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('Envoyer', SubmitType::class, ['attr' => ['class' => 'btn btn-success']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manifestation::class,
        ]);
    }
}
