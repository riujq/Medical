<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Objet',TextType::class,['label' => 'Objet','attr'=> ['placeholder'=>"Objet de la demande",'class'=>"my-2"],'row_attr' => ['class' => 'form-floating',]])
            ->add('Nom',TextType::class,['label' => 'Nom','attr'=> ['placeholder'=>"Votre Nom",'class'=>"my-2"],'row_attr' => ['class' => 'form-floating',]])
            ->add('Email',EmailType::class,['label'=>'Email','attr'=> ['placeholder'=>"Votre Email",'class'=>"my-2"],'row_attr' => ['class' => 'form-floating',]])
            ->add('PhoneNumber',TextType::class,['label'=>'Téléphone',
            'constraints' =>new Regex(pattern:'/^(261|0)(34|33|32)[0-9]{7}$/',message:"Le numero n'est pas valide"),
            'attr'=> ['placeholder'=>"Votre numero de Téléphone",'class'=>"my-2"],'row_attr' => ['class' => 'form-floating',]])
            ->add('CV', FileType::class, [
                'label' => 'Votre CV',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '5024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        ],
                        'mimeTypesMessage' => "Le format du fichier n'est pas valide (format valide: doc,docx,pdf,x-pdf taille inferieur a 5mo)",
                    ])
                ],
            ])
            ->add('Envoyer',SubmitType::class,['attr'=> ['class'=>'btn btn-primary my-2'],]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
