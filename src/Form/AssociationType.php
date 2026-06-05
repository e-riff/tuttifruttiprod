<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Association;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AssociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'form.association.name',
                'sanitize_html' => false,
            ])
            ->add('phone', null, [
                'label' => 'form.association.phone',
                'sanitize_html' => false,
            ])
            ->add('email', null, [
                'label' => 'form.association.email',
                'sanitize_html' => false,
            ])
            ->add('address', null, [
                'label' => 'form.association.address',
                'sanitize_html' => false,
            ])
            ->add('zipCode', null, [
                'label' => 'form.association.zip_code',
                'sanitize_html' => false,
            ])
            ->add('city', null, [
                'label' => 'form.association.city',
                'sanitize_html' => false,
            ])
            ->add('siret', null, [
                'label' => 'form.association.siret',
                'sanitize_html' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'form.association.description',
                'required' => false,
                'sanitize_html' => false,
            ])
            ->add('heroTitle', null, [
                'label' => 'form.association.home_banner_title',
                'required' => false,
                'sanitize_html' => false,
            ])
            ->add('heroSubtitle', TextareaType::class, [
                'label' => 'form.association.home_banner_subtitle',
                'required' => false,
                'sanitize_html' => false,
            ])
            ->add('heroImageFile', VichImageType::class, [
                'label' => 'form.association.home_banner_image',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Association::class,
            'translation_domain' => 'messages',
        ]);
    }
}
