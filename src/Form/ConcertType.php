<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Band;
use App\Entity\Concert;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConcertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('clientName', TextType::class, [
                'label' => 'form.admin.client_name',
                'attr' => [
                    'placeholder' => 'form.admin.client_name',
                    'class' => 'form-control',
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'form.association.address',
                'attr' => [
                    'placeholder' => 'form.association.address',
                    'class' => 'form-control',
                ],
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'form.admin.zip_code',
                'attr' => [
                    'placeholder' => 'form.admin.zip_code',
                    'class' => 'form-control',
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'form.admin.city',
                'attr' => [
                    'placeholder' => 'form.admin.city',
                    'class' => 'form-control',
                ],
            ])
            ->add('date', DateTimeType::class, [
                'label' => 'form.admin.date',
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'class' => 'form-control col-md-3',
                ],
            ])
            ->add('otherInformations', TextareaType::class, [
                'required' => false,
                'label' => 'form.admin.other_information',
                'attr' => [
                    'placeholder' => 'form.admin.other_information',
                    'class' => 'form-control',
                ],
            ])
            ->add('isConfirmed', CheckboxType::class, [
                'label' => 'admin.table.confirmed',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                ],
            ])
            ->add('band', EntityType::class, [
                'class' => Band::class,
                'choice_label' => 'name',
                'label' => 'form.admin.band',
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Concert::class,
            'translation_domain' => 'messages',
        ]);
    }
}
