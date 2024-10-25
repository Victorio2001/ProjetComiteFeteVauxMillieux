<?php

namespace App\Form;

use App\Entity\Materiel;
use App\Entity\MaterielReservation;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class MaterielReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantiteReservation',   TextType::class,
                options: [
                    'constraints' => [
                        new NotBlank(),
                        new Length(min:1, max:550),
                        new NotNull(),
                    ],
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Quantité réservation']
                ]
            )
            ->add('prixOrigine',   TextType::class,
                options: [
                    'constraints' => [
                        new NotBlank(),
                        new Length(min:1, max:550),
                        new NotNull(),
                    ],
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Prix d\'origine']
                ]
            )
            ->add('materiel', EntityType::class, [
                'class' => Materiel::class,
                'choice_label' => 'nomMateriel',
                'attr' => ['class' => 'form-select ']
            ])
//            ->add('reservation', EntityType::class, [
//                'class' => Reservation::class,
//                'choice_label' => 'id',
//                'attr' => ['class' => 'form-select ']
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MaterielReservation::class,
        ]);
    }
}
