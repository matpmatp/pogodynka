<?php

namespace App\Form;

use App\Entity\Forecast;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForecastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'attr' => [
                    'placeholder' => 'Select date',
                ],
            ])
            ->add('temperature', NumberType::class, [
                'scale' => 1,
                'attr' => [
                    'placeholder' => 'Enter temperature',
                ],
            ])
            ->add('pressure', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Enter atmospheric pressure',
                ],
            ])
            ->add('condition', ChoiceType::class, [
                'choices' => [
                    'Sunny' => 'sunny',
                    'Cloudy' => 'cloudy',
                    'Rainy' => 'rainy',
                    'Snowy' => 'snowy',
                    'Windy' => 'windy',
                ],
                'placeholder' => 'Choose weather condition',
            ])
            ->add('precipitation', NumberType::class, [
                'scale' => 1,
                'attr' => [
                    'placeholder' => 'Enter precipitation in %',
                ],
            ])
            ->add('humidity', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Enter humidity in %',
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'city',
                'placeholder' => 'Select city',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forecast::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
