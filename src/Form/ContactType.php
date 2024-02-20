<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom',TextType::class,['label' => 'Nom','attr'=> ['placeholder'=>"Votre Nom",'class'=>"my-2"],'row_attr' => ['class' => 'form-floating',]])
            ->add('Email',EmailType::class,['label'=>'Email','attr'=> ['placeholder'=>"Votre Email",'class'=>"my-2"],'row_attr' => ['class' => 'form-floating',]])
            ->add('PhoneNumber',TextType::class,['label'=>'Téléphone',
            'constraints' =>new Regex(pattern:'/^(261|0)(34|33|32)[0-9]{7}$/',message:"Le numero n'est pas valide"),
            'attr'=> ['placeholder'=>"Votre numero de Téléphone",'class'=>"my-2"],'row_attr' => ['class' => 'form-floating',]])
            ->add('Message',TextareaType::class,['label'=>'Message','attr'=> ['placeholder'=>"Votre message",'class'=>"my-2", 'style'=>"height: 150px"],'row_attr' => ['class' => 'form-floating',]])
            ->add('Envoyer',SubmitType::class,['attr'=> ['class'=>'btn btn-primary my-2'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
