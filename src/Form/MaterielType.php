<?php

namespace App\Form;

use App\Entity\Materiel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class MaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomMateriel',   TextType::class,
                options: [
                    'constraints' => [
                        new NotBlank(),
                        new Length(min:1, max:250),
                        new NotNull(),
                    ],
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Nom du Matériel']
                ]
            )
            ->add('imageMateriel',   FileType::class,
                    options: [
                        //https://stackoverflow.com/questions/40983353/the-forms-view-data-is-expected-to-be-an-instance-of-class-but-is-an-stri
                        'mapped' => false,
                        'required' => false,
                        //https://stackoverflow.com/questions/40983353/the-forms-view-data-is-expected-to-be-an-instance-of-class-but-is-an-stri
    //                    'constraints' => [
    //                        new NotBlank(),
    //                        new Length(min:1, max:250),
    //                        new NotNull(),
    //                    ],
                        'attr' => ['class' => 'form-control', 'placeholder' => 'Image Matériel']
                    ]
            )
            ->add('descriptionMateriel',   TextareaType::class,
                options: [
                    'constraints' => [
                        new NotBlank(),
                        new Length(min:1, max:250),
                        new NotNull(),
                    ],
                    'attr' => ['class' => 'form-control', 'rows'=> 4, 'placeholder' => 'Commentaire réservation']
                ]
            )
            ->add('prixMateriel',   IntegerType::class,
                options: [
                    'constraints' => [
                        new NotBlank(),
                        new NotNull(),
                    ],
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Prix du Matériel']
                ]
            )
            ->add('nombreExemplaireMateriel',   IntegerType::class,
                options: [
                    'constraints' => [
                        new NotBlank(),
                        new NotNull(),
                    ],
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Nombre d\'Exemplaire disponible']
                ]
            )
//            ->add('created_at', DateType::class, [
//                'widget' => 'single_text',
//                'attr' => ['class' => 'form-control']
//            ])
//            ->add('updated_at', DateType::class, [
//                'widget' => 'single_text',
//                'attr' => ['class' => 'form-control', 'placeholder' => 'Date de mis à jour']
//            ])
            ->add('Envoyer',  SubmitType::class, ['attr' => ['class' => 'btn btn-light shadow', 'placeholder' => '']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}
