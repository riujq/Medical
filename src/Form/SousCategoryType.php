<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\SousCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SousCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,['label' => 'nom','attr'=> ['placeholder'=>"nom de la sous-catégorie",'class'=>"my-2"],'row_attr' => ['class' => 'form-floating',]])
            ->add('imageFile', FileType::class, ['label' => 'Image', 'required' => false])
            ->add('category',EntityType::class,[
                'class'=>Category::class,
                'label' => 'Categorie',
                'choice_label'=> 'nom'                
            ])
            ->add('Enregistrer',SubmitType::class,['attr'=> ['class'=>'btn btn-primary my-2'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SousCategory::class,
        ]);
    }
}
