<?php

namespace App\Form;

use App\Entity\Association;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class AssociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomAssociation', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 255]),
                    new NotNull(),
                ],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Nom de l\'association']
            ])
            ->add('descriptionAssociation', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 1000]),
                    new NotNull(),
                ],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Description de l\'association']
            ])
            ->add('Envoyer', SubmitType::class, ['attr' => ['class' => 'btn btn-success']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Association::class,
        ]);
    }
}
