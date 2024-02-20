<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class,['label' => 'Titre','attr'=> ['placeholder'=>"Titre de l'article",'class'=>"my-2"],'row_attr' => ['class' => 'form-floating',]])
            ->add('content',TextType::class,['label' => 'Déscription','attr'=> ['placeholder'=>"Déscription de l'article",'class'=>"my-2", 'style'=>"height: 150px"],'row_attr' => ['class' => 'form-floating',]])
            ->add('image', FileType::class, [
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
            ->add('Enregistrer',SubmitType::class,['attr'=> ['class'=>'btn btn-primary my-2'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
