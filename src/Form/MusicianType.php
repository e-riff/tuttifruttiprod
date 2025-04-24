<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\Musician;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MusicianType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'sanitize_html' => true,
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'sanitize_html' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'sanitize_html' => true,
            ])
            ->add('isActive', CheckboxType::class, [
                "required" => true,
                'label' => 'Musicien Actif (visible sur le site)'
            ])
            ->add('pictureFile', VichImageType::class, [
                'required' => false,
                'imagine_pattern' => 'upload_filter',
                'allow_delete' => true,
                'download_uri' => true,
            ])
            ->add('bands', EntityType::class, [
                'label' => "Groupes",
                'class' => Band::class,
                "required" => false,
                'expanded' => true,
                'multiple' => true,
                'choice_label' => function (Band $musicStyle) {
                    return $musicStyle->getName();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Musician::class,
        ]);
    }
}
