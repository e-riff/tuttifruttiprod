<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Band;
use App\Entity\Event;
use App\Entity\Musician;
use App\Entity\MusicStyle;
use App\Enums\BandPriceEnum;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
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
                'label' => 'form.admin.group_name',
                'sanitize_html' => false,
            ])
            ->add('description', CKEditorType::class, [
                'sanitize_html' => false,
                'attr' => ['data-ckeditor' => true],
                'config_name' => 'light',
                'config' => ['editorplaceholder' => 'Une rapide description du groupe...'],
            ])
            ->add('isActive', CheckboxType::class, [
                'required' => false,
                'label' => 'form.admin.active_band',
            ])
            ->add('flashInformation', null, [
                'label' => 'form.admin.flash_information',
                'sanitize_html' => false,
            ])
            ->add('tagline', null, [
                'label' => 'form.admin.tagline',
                'sanitize_html' => false,
            ])
            ->add('priceCategory', EnumType::class, [
                'label' => 'form.admin.price_category',
                'required' => false,
                'class' => BandPriceEnum::class,
                'expanded' => false,
                'multiple' => false,
                'choice_label' => function (BandPriceEnum $choice) {
                    return $choice->value;
                },
            ])
            ->add('events', EntityType::class, [
                'label' => 'form.admin.event_types',
                'class' => Event::class,
                'required' => false,
                'expanded' => true,
                'multiple' => true,
                'choice_label' => function (Event $event) {
                    return $event->getName();
                },
            ])
            ->add('musicStyles', EntityType::class, [
                'label' => 'form.admin.music_styles',
                'class' => MusicStyle::class,
                'required' => false,
                'expanded' => true,
                'multiple' => true,
                'choice_label' => 'name',
            ])
            ->add('leader', EntityType::class, [
                'class' => Musician::class,
                'choice_label' => function (Musician $musician) {
                    return "{$musician->getLastname()} {$musician->getFirstname()}";
                },
                'required' => false,
                'placeholder' => 'form.admin.select_leader',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('musicians', EntityType::class, [
                'label' => 'form.admin.musicians',
                'class' => Musician::class,
                'choice_label' => function (Musician $musician) {
                    return "{$musician->getLastname()} {$musician->getFirstname()}";
                },
                'required' => false,
                'placeholder' => 'form.admin.select_leader',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('pictureFile', VichImageType::class, [
                'label' => 'form.admin.photo',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'constraints' => [
                    new Image([
                        'minRatio' => 1.5,
                        'maxRatio' => 2.5,
                        'maxSize' => '6M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG, GIF)',
                    ]),
                ],
            ])
            ->add('color', ColorType::class, [
                'label' => 'form.admin.color',
                'html5' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
            'translation_domain' => 'messages',
        ]);
    }
}
