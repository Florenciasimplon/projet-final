<?php

namespace App\Form;

use App\Entity\Menu;
use App\Entity\Restaurant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_menu',TextType::class,[
                'label' => 'Nom du menu'])
            ->add('prix',NumberType::class,[
                'label' => 'Prix total du menu'])
            // ->add('restaurant',EntityType::class, [
            //         'class' => Restaurant::class,
            //     'mapped'=>false,
            // ])
            ->add('entrer',TextType::class,[
                'label' => 'Entré'])
            ->add('plats',TextType::class,[
                    'label' => 'Plats'])
            ->add('dessert',TextType::class,[
                        'label' => 'Dessert'])

            ->add('entrer_2',TextType::class,[
                'label' => 'Entré N°2'])
            ->add('plats_2',TextType::class,[
                'label' => 'Plats N°2'])
            ->add('Dessert_2',TextType::class,[
                'label' => 'Dessert N°2'])
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
