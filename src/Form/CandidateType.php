<?php

namespace App\Form;

use App\Entity\Utilisateur;
use App\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;


class CandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                
            ])
            ->add('num_tel', TextType::class, [
                'label' => 'Numéro de téléphone',
                'required' => true,
                'constraints' => [
                
                    new Assert\Regex([
                        'pattern' => '/^[0-9]{8}$/',
                        'message' => 'Le numéro de téléphone doit contenir  8  chiffres.',
                    ]),
                ],
            ])
            ->add('birthdayDate', BirthdayType::class, [
                'label' => 'Date de Naissance',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('joiningDate', DateType::class, [
                'label' => 'Date de Postulation',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('uploaded_cv', FileType::class, [
                'label' => 'CV (PDF, DOCX...)',
                'mapped' => false, // Champ non mappé
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => '🚨 Veuillez sélectionner un fichier à uploader.',
                    ]),
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader un fichier valide (PDF ou Word).',
                    ])
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [
                    'Homme' => Genre::HOMME,
                    'Femme' => Genre::FEMME,
                    
                ],
                'expanded' => false,
                'multiple' => false,
                'choice_label' => fn ($choice, $key, $value) => $key,
            ])
            ->add('Confirmer', SubmitType::class, [
                'attr' => ['class' => 'btn']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
