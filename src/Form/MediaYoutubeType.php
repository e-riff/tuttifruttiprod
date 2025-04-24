<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MediaYoutubeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('link', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 5 ])
                ],
                'label' => "Lien ou ID de la video",
                'attr' => ['placeholder' =>  "'5Afzed45' - https://www.youtube.com/watch?v=5Afzed45"],
                'row_attr' => ['class' => 'p-2'],
                'sanitize_html' => true,
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
                'row_attr' => ['class' => 'text-center pb-2'],
            ])
        ;
    }
}
