<?php

namespace App\Form\Ressource;

use App\Entity\Resource;
use App\Form\Social\SocialType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RessourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la resource',
                'required' => true,
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('plainSocials', CollectionType::class, [
                'label' => false,
                'entry_type' => SocialType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Resource::class,
        ]);
    }
}
