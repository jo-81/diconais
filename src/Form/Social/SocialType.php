<?php

namespace App\Form\Social;

use App\Entity\ResourceSocial;
use App\Enum\SocialIconEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Url;

class SocialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('icon', EnumType::class, [
                'label' => false,
                'class' => SocialIconEnum::class,
                'attr' => [
                    'class' => 'col-1',
                ],
            ])
            ->add('link', UrlType::class, [
                'label' => false,
                'constraints' => [
                    new Url(),
                ],
            ])
            ->add('remove', ButtonType::class, [
                'attr' => ['data-action' => 'form-social-collection#removeCollectionElement'],
            ])
            ->get('icon')
                ->addModelTransformer(new CallbackTransformer(
                    function ($social): ?string {
                        return $social;
                    },
                    function ($social): string {
                        return $social->name;
                    }
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResourceSocial::class,
        ]);
    }
}
