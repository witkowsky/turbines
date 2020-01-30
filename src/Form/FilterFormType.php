<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('turbines', TextareaType::class, [
                'label' => 'turbiny do wyszukania'
            ])
            ->add('action', ChoiceType::class, [
                'choices' => [
                    'sprawdz' => 'check',
                    'pobierz gpx' => 'gpx',
                    'pobierz kml' => 'kml',
                ],
                'required' => true,
                'label' => 'Akcja'
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
