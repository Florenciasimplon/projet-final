<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email')
        ->add('nom')
        ->add('prenom')
        ->add('adresse',TextType::class,[
            'required'=>true,
            'empty_data'=>''
        ])
        ->add('code_postal',TextType::class,[
            'attr' => ['pattern' => "^(([0-8][0-9])|(9[0-5])|(2[ab]))[0-9]{3}$", 'maxlength' => 5]
        ])
        ->add('date_anniversaire',DateType::class,[
            'html5' => false,
            'widget' => 'single_text',
            'format'=> 'dd-MM-yyyy'
        ])
        ->add('telephone', TextType::class,[
            'attr' => ['pattern' => "^(?:(?:+|00)33[\s.-]{0,3}(?:(0)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$" , 'maxlength' => 10]
        ])
        ->add('picture', FileType::class,[
            'label' => 'image profil',
            'mapped' => false,
            'required' => false,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
    
}
