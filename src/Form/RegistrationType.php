<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,['label' => 'Email','attr'=> ['placeholder'=>"Email",'class' => 'my-2'],'row_attr' => ['class' => 'form-floating',]])
            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message'=> 'Le mot de passe et la confirmation doivent être identique',
                'label' => 'Mon mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Votre mot de passe',
                    'attr'=> ['placeholder'=>'Merci de saisir votre mot de passe','class' => 'my-2'],'row_attr' => ['class' => 'form-floating',]
                ], 
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr'=> ['placeholder'=>'Merci de confirmez votre mot de passe','class' => 'my-2'],'row_attr' => ['class' => 'form-floating',]
                    ]              
                ])
            ->add("Inscription",SubmitType::class,['attr'=> ['class'=>'btn btn-primary my-2 w-100'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
