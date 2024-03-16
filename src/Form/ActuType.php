<?php

namespace App\Form;

use App\Entity\Actu;
use App\Entity\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ActuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type',EntityType::class,[
                'class'=>Type::class,
                'label' => 'Type',
                'choice_label'=> 'nom'                
            ])
            ->add('Nom',TextType::class,['label' => 'Nom','attr'=> ['placeholder'=>'Titre','class'=>"my-2"],'row_attr' => ['class' => 'form-floating',]])
            ->add('Description',TextareaType::class,['label' => 'Déscription','attr'=> ['placeholder'=>"Déscription",'class'=>"my-2", 'style'=>"height: 150px"],'row_attr' => ['class' => 'form-floating',]])
            ->add('Date',DateType::class)
            ->add('imageFile', FileType::class, ['label' => 'Image','required' => false])
            ->add('Enregistrer',SubmitType::class,['attr'=> ['class'=>'btn btn-primary my-2'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Actu::class,
        ]);
    }
}
