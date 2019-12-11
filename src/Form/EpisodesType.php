<?php

namespace App\Form;

use App\Entity\Episodes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EpisodesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('summary')
            ->add('number')
            ->add('season')
            ->add('duration')
            ->add('premiere')
            ->add('url')
            ->add('image')
            ->add('created_at')
            ->add('Series')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Episodes::class,
        ]);
    }
}
