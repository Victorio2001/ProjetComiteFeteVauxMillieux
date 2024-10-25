<?php

namespace App\Form;

use App\Entity\Materiel;
use App\Entity\MaterielReservation;
use App\Entity\Reservation;
use App\Entity\User;

use App\Repository\MaterielReservationRepository;
use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\BooleanType;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateReservation', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de la Réservation:',
                'attr' => ['class' => 'form-control']
            ])
            ->add('commentaireReservation', TextareaType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 550]),
                    new NotNull(),
                ],
                'attr' => ['class' => 'form-control', 'rows'=> 4, 'placeholder' => 'Commentaire réservation']
            ])
            ->add('etat', ChoiceType::class, [
                'label' => 'Etat de la Réservation:',
                'choices' => [
                    'En attente' => 'En attente',
                    'En-cours' => 'En-cours',
                    'Annulée' => 'Annulée',
                    'Terminée' => 'Terminée',
                    'Archivée' => 'Archivée',
                ],
                'attr' => ['class' => 'form-control']
            ])

            ->add('nomAsso', ChoiceType::class, [
                'label' => 'Type de structure',
                'choices' => [
                    'association' => 'association',
                    'particulier' => 'particulier',
                ],
                'attr' => ['class' => 'form-select']
            ])

            ->add('mailReservation',   TextType::class,
                options: [
                    'constraints' => [
                        new NotBlank(),
                        new Length(min:1, max:250),
                        new NotNull(),
                    ],
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Mail réservation']
                ]
            )


            ->add('nomUserReservation',   TextType::class,
                options: [
                    'constraints' => [
                        new NotBlank(),
                        new Length(min:1, max:250),
                        new NotNull(),
                    ],
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Nom Utilisateur']
                ]
            )
            ->add('numeroReservant',   IntegerType::class,
                options: [
                    'constraints' => [
                        new NotBlank(),
                        new Length(min:1, max:250),
                        new NotNull(),
                    ],
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Numéro réservant']
                ]
            )
            ->add('prenomUserReservation',   TextType::class,
                options: [
                    'constraints' => [
                        new NotBlank(),
                        new Length(min:1, max:250),
                        new NotNull(),
                    ],
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Prenom Utilisateur']
                ]
            )

            ->add('dateRetour', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de Retour:',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateEmprunt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de l\'Emprunt:',
                'attr' => ['class' => 'form-control']
            ])

//            ->add('Utilisateur', EntityType::class, [
//                'class' => User::class,
//                'choice_label' => 'Nom',
//                'attr' => ['class' => 'form-select']
//            ])
            ->add('MaterielReservation', CollectionType::class, [
                'entry_type' => MaterielReservationType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'label' => false,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('archiverReservation', CheckboxType::class, [
                'attr' => ['class' => 'form-check'],
                'label' => 'Archiver la réservation:',
                'required' => false,
            ])
            ->add('Envoyer', SubmitType::class, ['attr' => ['class' => 'btn btn-light']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
