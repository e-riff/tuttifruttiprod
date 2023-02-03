<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\MusicStyle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MusicStyleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('bands', EntityType::class, [
                'class' => Band::class,
                "required" =>false,
                'expanded' => true,
                'multiple' => true,
                'choice_label' => function (Band $band) {
                    return $band->getName();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MusicStyle::class,
        ]);
    }
}
