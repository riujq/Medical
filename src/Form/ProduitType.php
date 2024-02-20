<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\SousCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,['label' => 'nom','attr'=> ['placeholder'=>'nom du produit','class'=>"my-2"],'row_attr' => ['class' => 'form-floating',]])
            ->add('Reference',TextType::class,['label' => 'Référence','attr'=> ['placeholder'=>'Référence du produit','class'=>"my-2"],'row_attr' => ['class' => 'form-floating',]])
            ->add('Description',TextareaType::class,['label' => 'Déscription','attr'=> ['placeholder'=>"Déscription du produit",'class'=>"my-2", 'style'=>"height: 150px"],'row_attr' => ['class' => 'form-floating',]])
            ->add('Image', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/gif',
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'veuillez choisir un format image valide',
                    ])
                ],
            ])
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
