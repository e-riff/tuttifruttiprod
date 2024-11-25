<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\BandPriceEnum;
use App\Entity\Event;
use App\Entity\MusicStyle;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom du groupe',
                'purify_html' => true,
            ])
            ->add('description', CKEditorType::class, [
                'purify_html' => true,
                'attr' => ['data-ckeditor' => true],
                'config_name' => 'light',
                'config' => ['editorplaceholder' => "Une rapide description du groupe..."]
            ])
            ->add('isActive', CheckboxType::class, [
                "required" => true,
                'label' => 'Groupe Actif (visible sur le site)'
            ])
            ->add('flashInformation', null, [
                'purify_html' => true
            ])
            ->add('tagline', null, [
                'label' => "Phrase d'accroche",
                'purify_html' => true
            ])
            ->add('priceCategory', EnumType::class, [
                'label' => "Catégorie de prix",
                "required" => false,
                'class' => BandPriceEnum::class,
                'expanded' => false,
                'multiple' => false,
                'choice_label' => function (BandPriceEnum $choice) {
                    return $choice->value;
                },
            ])
            ->add('events', EntityType::class, [
                'label' => "Type d'événements du groupe",
                'class' => Event::class,
                "required" => false,
                'expanded' => true,
                'multiple' => true,
                'choice_label' => function (Event $event) {
                    return $event->getName();
                }
            ])
            ->add('musicStyles', EntityType::class, [
                'label' => "Styles musicaux",
                'class' => MusicStyle::class,
                "required" => false,
                'expanded' => true,
                'multiple' => true,
                'choice_label' => function (MusicStyle $musicStyle) {
                    return $musicStyle->getName();
                }
            ])
            ->add('pictureFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'constraints' => [
                    new Image([
                        'minWidth' => 600,
                        'maxWidth' => 3000,
                        'minHeight' => 600,
                        'maxHeight' => 2000,
                        'minRatio' => 1.5,
                        'maxRatio' => 2.5,
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG, GIF)',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}
