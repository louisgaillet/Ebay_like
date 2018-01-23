<?php

namespace ProductsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array(
                'label' => 'Titre du Produit',
            ))
            ->add('price', IntegerType::class, array(
                'label' => 'Prix du produit',
            ))
            ->add('description',TextareaType::class, array(
                'label' => 'Description du produit',
            ))
            ->add('imageFile',FileType::class, array(
                'label' => 'Image du produit',
            ))
            ->add('categories', EntityType::class, array(
                'class'        => 'ProductsBundle\Entity\Category',
                'choice_label' => 'name',
                'multiple'     => true,
                'label'        => 'Categorie du produit'
            ))
            ->add('startingPrice',IntegerType::class, array(
                'label' => "Prix de départ de l'enchère",
            ))
            ->add('minBid',IntegerType::class, array(
                'label' => "Minimum de l enchère",
            ))
            ->add('dateEnd',DateType::class, array(
                'label' => "Date de fin de l'enchère",
            ))
            ->add('save', SubmitType::class, ['label' => 'Create Product']);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProductsBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'productsbundle_product';
    }


}
