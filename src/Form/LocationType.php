<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', null, [
                'attr' => [
                    'placeholder' => 'Enter city name',
                ],
            ])
            ->add('country', ChoiceType::class, [
                'choices' => [
                    'Poland' => 'Poland',
                    'Germany' => 'Germany',
                    'France' => 'France',
                    'Spain' => 'Spain',
                    'Italy' => 'Italy',
                    'United Kingdom' => 'United Kingdom',
                    'United States' => 'United States',
                ],
            ])
            ->add('latitude', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Enter latitude',
                ],
            ])
            ->add('longitude', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Enter longitude',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
