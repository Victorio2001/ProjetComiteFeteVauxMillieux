<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',   TextType::class,
                options: [
                    'constraints' => [
                        new NotBlank(),
                        new Length(min:1, max:250),
                        new NotNull(),
                    ],
                    'attr' => ['class' => 'form-control', 'placeholder' => 'email']
                ]
            )

            ->add('nom',  TextType::class,
                options: [
                    'constraints' => [
                        new NotBlank(),
                        new NotNull(),
                    ],
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Nom']
                ]
            )
            ->add('prenom',  TextType::class,
                options: [
                    'constraints' => [
                        new NotBlank(),
                        new NotNull(),
                    ],
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Prénom']
                ]
            )

            ->add('roles', EntityType::class, [
                'class' => Role::class,
                'choice_value' => 'id',
                'choice_label' => 'label',
                'multiple' => true,
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Role']
            ]

            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
