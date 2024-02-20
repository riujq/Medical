<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReqPassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,['label' => 'Entrer votre email: ','required' => true,
                'attr'=> ['placeholder'=>"Entrer votre email"],
                'row_attr' => ['class' => 'form-floating']
                ])
            ->add('Envoyer',SubmitType::class,['attr'=> ['class'=>'btn btn-primary my-2 w-100'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
