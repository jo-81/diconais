<?php

namespace App\Form\Social;

use App\Entity\Social;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('color', ColorType::class, [
                'label' => 'Couleur',
            ])
            ->add('icon', ChoiceType::class, [
                'choices' => [
                    'Facebook' => 'fa-brands fa-facebook fa-lg',
                    'Twitter' => 'fa-brands fa-twitter fa-lg',
                    'Youtube' => 'fa-brands fa-youtube fa-lg',
                    'Twitch' => 'fa-brands fa-twitch fa-lg',
                    'Instagram' => 'fa-brands fa-instagram fa-lg',
                    'Website' => 'fa-solid fa-globe fa-lg',
                    'Reddit' => 'fa-brands fa-reddit-alien',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Social::class,
        ]);
    }
}
