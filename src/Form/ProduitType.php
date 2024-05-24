<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\SousCategory;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,['label' => 'nom','attr'=> ['placeholder'=>'nom du produit','class'=>"my-2"],'row_attr' => ['class' => 'form-floating',]])
            ->add('Reference',TextType::class,['label' => 'Référence','attr'=> ['placeholder'=>'Référence du produit','class'=>"my-2"],'row_attr' => ['class' => 'form-floating',]])
            ->add('Description',CKEditorType::class)
            ->add('imageFile', FileType::class, ['label' => 'Image', 'required' => false])
            ->add('Prix',MoneyType::class,['label' => 'Prix','attr'=> ['placeholder'=>"Prix du produit"],'currency'=>''])
            ->add('sousCategory',EntityType::class,[
                'label' => 'sous Categorie',
                'class'=>SousCategory::class,
                'choice_label'=> function($s) {return $s->getCategory()->getNom()." : -".$s->getnom();}                
            ])
            ->add('Enregistrer',SubmitType::class,['attr'=> ['class'=>'btn btn-primary my-2'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
