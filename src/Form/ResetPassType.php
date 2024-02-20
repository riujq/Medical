<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ResetPassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message'=> 'Le mot de passe et la confirmation doivent être identique',
                'label' => 'Mon nouveau mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Mon nouveau mot de passe',
                    'attr'=> ['placeholder'=>'Merci de saisir votre nouveau mot de passe','class' => 'my-2'],'row_attr' => ['class' => 'form-floating',]
                ], 
                'second_options' => [
                    'label' => 'Confirmez votre nouveau mot de passe',
                    'attr'=> ['placeholder'=>'Merci de confirmez votre nouveau mot de passe','class' => 'my-2'],'row_attr' => ['class' => 'form-floating',]
                    ]              
                ])
            ->add('Valider',SubmitType::class,['attr'=> ['class'=>'btn btn-primary my-2'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
