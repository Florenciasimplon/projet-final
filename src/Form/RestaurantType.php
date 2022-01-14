<?php

namespace App\Form;

use App\Entity\Restaurant;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_restaurant',TextType::class,[
                'label' => 'Nom du restaurant'
            ])
            ->add('description',TextType::class,[
                'label' => 'Ajouter une description à votre restaurant',
                'required'=>true,
                'empty_data'=>''
            ])
            ->add('telephone_restaurant', TextType::class,[
                'attr' => ['pattern' => "^(?:(?:+|00)33[\s.-]{0,3}(?:(0)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$" , 'maxlength' => 10],
                'label' => 'Numéros du restaurant'
                ])
            ->add('adresse_restaurant',TextType::class,[
                'required'=>true,
                'empty_data'=>'',
                'label' => 'Adresse du restaurant'
            ])
            ->add('parking', CheckboxType::class,[
                'attr' => ['class'=> 'filled-in'],
                'label'=>'Parking ',
                'required' => false,
            ])
            ->add('animaux',CheckboxType::class,[
                'attr' => ['class'=> 'filled-in'],
                'label'=>'Animaux ',
                'required' => false,
            ])
            ->add('climatisation',CheckboxType::class,[
                'attr' => ['class'=> 'filled-in'],
                'label'=>'Climatisation ',
                'required' => false,
            ])

            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     // 'mapped'=>false,
            // ])
            ->add('picture_restaurant',FileType::class, [
                'multiple' => true,
                'mapped'=> false,
            ])
            ->add('codepostal_restaurant',TextType::class,[
                'attr' => ['pattern' => "^(([0-8][0-9])|(9[0-5])|(2[ab]))[0-9]{3}$", 'maxlength' => 5]
            ])
            ->add('acces_handicape', CheckboxType::class,[
                'attr' => ['class'=> 'filled-in'],
                'label'=>'Parking ',
                'required' => false,
            ])
            ->add('place_maximum',TextType::class,[
                'label' => 'Nombres de places disponible dans votre restaurant'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
