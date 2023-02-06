<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\MusicStyle;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'purify_html' => true,
            ])
            ->add('description', CKEditorType::class, [
                'purify_html' => true,
                'attr' => ['data-ckeditor' => true],
                'config_name' => 'light',
                'config' => ['editorplaceholder' => "Une rapide description du groupe..."]
            ])
            ->add('isActive', null, [
                "required" => false
            ])
            ->add('flashInformation', null, [
                'purify_html' => true
            ])
            ->add('tagline', null, [
                'purify_html' => true
            ])
            //->add('events')
            ->add('musicStyles', EntityType::class, [
                'class' => MusicStyle::class,
                "required" => false,
                'expanded' => true,
                'multiple' => true,
                'choice_label' => function (MusicStyle $musicStyle) {
                    return $musicStyle->getName();
                }
            ])
            ->add('pictureFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}
